<?php

namespace App\Helpers;

class StaticDataHelper
{
    public static function getData()
    {
        return [
            'address' => [
                'Bumthang Branch' => 'Bumthang Branch',
                'Corporate Banking' => 'Corporate Banking',
                'Corporate Office' => 'Corporate Office',
                'Dagapela Extension' => 'Dagapela Extension',
                'Gasa Extension' => 'Gasa Extension',
                'Gelephu Branch' => 'Gelephu Branch',
                'Gomtu Extension' => 'Gomtu Extension',
                'Gyelposhing Extension' => 'Gyelposhing Extension',
                'Haa Extension' => 'Haa Extension',
                'Kanglung Extension' => 'Kanglung Extension',
                'Khuruthang Extension' => 'Khuruthang Extension',
                'Lhuntse Extension' => 'Lhuntse Extension',
                'Lingmithang Extension' => 'Lingmithang Extension',
                'Mongar Branch' => 'Mongar Branch',
                'Motithang Extension' => 'Motithang Extension',
                'Nganglam Extension' => 'Nganglam Extension',
                'Paro Branch' => 'Paro Branch',
                'Phuntsholing Branch' => 'Phuntsholing Branch',
                'Rangjung Extension' => 'Rangjung Extension',
                'Samdrupcholing Extension' => 'Samdrupcholing Extension',
                'Samdrupjongkhar Branch' => 'Samdrupjongkhar Branch',
                'Samtse Branch' => 'Samtse Branch',
                'Sarpang Extension' => 'Sarpang Extension',
                'Tala Extension' => 'Tala Extension',
                'Tashicholing Extension' => 'Tashicholing Extension',
                'Tashiyangtsi Extension' => 'Tashiyangtsi Extension',
                'Thimphu Branch' => 'Thimphu Branch',
                'Tingtibi Extension' => 'Tingtibi Extension',
                'Trashigang Branch' => 'Trashigang Branch',
                'Trongsa Extension' => 'Trongsa Extension',
                'Tsirang Branch' => 'Tsirang Branch',
                'Wamrong Extension' => 'Wamrong Extension',
                'Wangdue Branch' => 'Wangdue Branch'
            ],

            'vertical' => [
                'Banking Operation' => 'Banking Operation',
                'Customer Experience' => 'Customer Experience',
                'Corporate Service' => 'Corporate Service'
            ],

            'unit' => [
                'Customer Experience' => [
                    'IT Operations Department' => 'IT Operations Department',
                    'Customer Service Department' => 'Customer Service Department',
                    'Digital Transformation Department' => 'Digital Transformation Department',
                ],
                'Banking Operation' => [
                    'Branch Operations Department' => 'Branch Operations Department',
                    'Remedial Management Department' => 'Remedial Management Department',                      
                ],
                
                'Corporate Service' => [
                    'Finance Department' => 'Finance Department',
                    'Human Resource Administration Department' => 'Human Resource Administration Department',
                ],
                'Others' => [
                    'Internal Audit Department' => 'Internal Audit Department',
                    'Risk, Review and Compliance Department' => 'Risk, Review and Compliance Department',
                    'Strategy Management Department' => 'Strategy Management Department',
                    'VAS Division' => 'VAS Division',
                    'Executive Members' => 'Executive Members',
                ]
                
           
            ],
         
            'dispatchNumberPattern' => '/^[A-Z]{3}\/[A-Z]{3}\/[A-Z]{3}\/\d{4}-\d{2}-\d{2}\/[1-9]\d*$/',
            'risk_type' => [
                'High' => 'High',
                'Medium' => 'Medium',
                'Low' => 'Low'
            ],
            'issue_type' => [
                'Value Idea' => 'Value Idea',
                'Compliance' => 'Compliance',
                'Control' => 'Control',
                'Efficincy' => 'Efficiency'
            ],
            'status' => [
                'Resolved' => 'Resolved',
                'Pending' => 'Pending',
                'Compliance Check' => 'Compliance Check'
            ],
            'meeting_type' => [
                'EMC' => 'EMC',
                'BAC' => 'BAC',
                'Resource Vertical' => 'Resource Vertical',
                'Customer Service Vertical' => 'Customer Service Vertical',
                'Customer Experience Vertical' => 'Customer Experience Vertical',
                'Banking Operations Vertical' => 'Banking Operations Vertical',
                'Strategy Vertical' => 'Strategy Vertical'
            ]
        ];
    }
}
