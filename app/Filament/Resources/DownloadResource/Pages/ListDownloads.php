<?php

namespace App\Filament\Resources\DownloadResource\Pages;

use App\Filament\Resources\DownloadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Engagement;
use Filament\Forms\Components\Select;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Chiiya\FilamentAccessControl\Models\FilamentUser;

class ListDownloads extends ListRecords
{
    protected static string $resource = DownloadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            Actions\Action::make('Download')
                ->form([
                    Select::make('download_type')
                        ->label('Download')
                        ->options([
                            "self" => "Self",
                            "overall" => "Overall"
                        ])
                        ->required(),
                ])
                ->action(function (array $data): BinaryFileResponse {
                    if ($data['download_type'] == "self") {
                        $user = auth()->user();
                        $engagements = Engagement::where('created_by', $user->id)->get();
                        return $this->downloadExcelFile($engagements, 'engagements.xlsx');
                    } else {
                        $engagements = Engagement::all(); // Fetch all engagements
                        return $this->downloadExcelFile($engagements, 'engagements.xlsx');
                    }
                })
        ];
    }

    protected function downloadExcelFile(Collection $engagements, string $fileName): BinaryFileResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the headings (field names as Excel headers)
        $headings = [
           'Engagement#', 'Auditee', 'Vertical',
            'Issue title', 'Issue description', 'Response', 'Remarks', 'Risk Type', 'Issue Type', 'EMC', 'Audit Year',  'Due Date', 'Status', 'Auditor'
        ];
        $sheet->fromArray([$headings]);

        // Add data rows
        foreach ($engagements as $engagement) {
            $user = FilamentUser::find($engagement->created_by); // Fetch the user based on created_by ID
            $createdByName = $user ? $user->name : 'Unknown';
            $year = $engagement->created_at->year;
            if ($engagement->issues->isEmpty()) {
                // Add an empty row for the engagement if it doesn't have any issues
                $rowData = [
                    $engagement->dispatch_number,
                    $engagement->address,
                    $engagement->vertical,
                    '', // Title
                    '', // Description
                    '', // Response
                    '', // Remarks
                    '', // Risk Type
                    '', // Issue Type
                    '',
                    $year,
                    '', // Completion Date
                    '', // Status
                    $createdByName,
                ];
                $sheet->fromArray([$rowData], null, 'A' . ($sheet->getHighestRow() + 1));
            } else {
                foreach ($engagement->issues as $issue) {
                    $rowData = [
                        $engagement->dispatch_number,
                        $engagement->address,
                        $engagement->vertical,
                        $issue->title,
                        $issue->description,
                        $issue->response,
                        $issue->remarks,
                        $issue->risk_type,
                        $issue->issue_type,
                        $issue->emc === 1 ? 'yes' : 'no',
                        $year,
                        $issue->completion_date,
                        $issue->status,
                        $createdByName,
                    ];
                    $sheet->fromArray([$rowData], null, 'A' . ($sheet->getHighestRow() + 1));
                }
            }
        }

        $writer = new Xlsx($spreadsheet);
        $tempFilePath = storage_path('app/public/' . $fileName);

        // Save the file to a temporary location
        $writer->save($tempFilePath);

        // Download the file
        return response()->download($tempFilePath)->deleteFileAfterSend();
    }
}
