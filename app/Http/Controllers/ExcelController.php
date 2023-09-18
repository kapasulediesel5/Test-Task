<?php

namespace App\Http\Controllers;

use App\Rules\MaxFileSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelController extends Controller
{
    /***
     *  showForm returns the fileUpload view in the browser.
     */
    public function showForm()
    {
        return view('imports.fileUpload');
    }

    /***
     * Imports an XLSX file uploaded from the browser and processes it, returning a message to the browser.
     */
    public function import(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'file' => ['required', 'file', 'mimes:xlsx', new MaxFileSize(20)],
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            $importCount = 0;
            $duplicateCount = 0;
            $duplicateRecords = [];

          // adjust chunkSize according  to your server
            $chunks = array_chunk($rows, 100);

            DB::beginTransaction();

            foreach ($chunks as $chunk) {
                $data = [];

                foreach ($chunk as $row) {
                    $existingRecord = DB::table('catalog')
                        ->where("Model Code (Manufacturer's SKU)", $row[5])
                        ->first();

                    if ($existingRecord) {
                        $duplicateCount++;
                        $duplicateRecords[] = $row[5];
                        continue;
                    }

                    $data[] = [
                        'Category' => $row[0],
                        'Category_' => $row[1],
                        'Product Category' => $row[2],
                        'Manufacturer' => $row[3],
                        'Product Name' => $row[4],
                        "Model Code (Manufacturer's SKU)" => $row[5],
                        'Product Description' => $row[6],
                        'Retail Price UAH (Ukrainian Hryvnia)' => $row[7],
                        'Warranty' => $row[8],
                        'Availability' => $row[9],
                    ];

                    $importCount++;
                }

                DB::table('catalog')->insert($data);
            }

            DB::commit();

            $message = 'File imported successfully. Imported: ' . $importCount . ' records.';
            if ($duplicateCount > 0) {
                $message .= ' Skipped ' . $duplicateCount . ' duplicates.';
                $message .= ' Duplicates: ' . implode(', ', $duplicateRecords);
            }

            return redirect('/import')->with('success', $message);

        } catch (\Exception $e) {

            DB::rollBack();
            return redirect('/import')->with('error', 'An error occurred during import. Please try again later.');
        }
    }

}
