<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class Engagement extends Model
{
    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class);
    }

    public function getYearAttribute()
    {
        return Carbon::parse($this->created_at)->year;
    }

    // Method to fetch issues for a specific year
    public function issuesForYear($year)
    {
        return $this->issues()->whereYear('created_at', $year)->get();
    }

 public function getTotalIssuesAttribute()
    {
        $issues = $this->issues()->get(['risk_type'])->pluck('risk_type')->toArray();
        $highCount = collect($issues)->filter(fn ($riskType) => $riskType === 'High')->count();
        $mediumCount = collect($issues)->filter(fn ($riskType) => $riskType === 'Medium')->count();
        $lowCount = collect($issues)->filter(fn ($riskType) => $riskType === 'Low')->count();

        $formattedString = "Total Issues: " . count($issues) . "\n";
        $formattedString .= "H: " . $highCount . "\n";
        $formattedString .= "M: " . $mediumCount . "\n";
        $formattedString .= "L: " . $lowCount;

        return $formattedString;
    }

    public function getPendingPercentageAttribute()
    {
        return $this->calculateStatusPercentage('Pending');
    }

    public function getResolvedPercentageAttribute()
    {
        return $this->calculateStatusPercentage('Resolved');
    }

    public function getComplianceCheckPercentageAttribute()
    {
        return $this->calculateStatusPercentage('Compliance Check');
    }

    private function calculateStatusPercentage($status)
    {
        $issues = $this->issues()->get(['status'])->pluck('status')->toArray();
        $statusCount = collect($issues)->filter(fn ($issueStatus) => $issueStatus === $status)->count();
        $totalIssues = count($issues);

        if ($totalIssues == 0) {
            return 0;
        }

        return round(($statusCount / $totalIssues) * 100, 2);
    }


    public function getAuditOpinionAttribute()
    {
        $totalIssues = (int) $this->issues()->count(); // Ensure integer type
        if ($totalIssues == 0) {
            return 'No issues found';
        }
    
        $highIssues = (int) $this->issues()->where('risk_type', 'High')->count(); // Ensure integer type
        $percentageHigh = ($highIssues / $totalIssues) * 100;
    
        if ($percentageHigh < 33) {
            return 'Effective';
        } elseif ($percentageHigh >= 33 && $percentageHigh < 50) {
            return 'Some improvement Needed';
        } elseif ($percentageHigh >= 50 && $percentageHigh < 100) {
            return 'Major Improvement Needed';
        } else {
            return 'Unsatisfactory';
        }
    }
    
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
            }
        });

    }

     // Scope to filter engagements by the current year
     public function scopeCurrentYear($query): Builder
     {
         return $query->whereYear('created_at', Carbon::now()->year);
     }

}
