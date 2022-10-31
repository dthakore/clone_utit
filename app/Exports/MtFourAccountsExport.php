<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class MtFourAccountsExport implements FromCollection, WithCustomCsvSettings, WithHeadings
{
    protected $login;
    protected $email;
    protected $agent;
    protected $broker;
    protected $priceStart = 0.00;
    protected $priceEnd = 100000.00;

    function __construct($data) {
        if($data['login'] != null){
            $this->login = $data['login'];
        }
        if($data['email'] != null){
            $this->email = $data['email'];
        }
        if($data['agent'] != null){
            $this->agent = $data['agent'];
        }
        if($data['broker'] != null){
            $this->broker = $data['broker'];
        }
        if($data['toAmount'] != null){
            $this->priceEnd = number_format($data['toAmount'], 2, '.', '');
        }
        if($data['fromAmount'] != null){
            $this->priceStart = number_format($data['fromAmount'], 2, '.', '');
        }
        
    }
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ','
        ];
    }
    public function headings(): array
    {
        return ["Login","Name","Balance","Equity","Email", "Agent","Brand","Leverage","Max Equity","Max balance","Brokers"];
    }
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        $whereQuery = "";
        if(isset($this->login) || isset($this->email) || isset($this->agent) || isset($this->broker) || $this->priceStart > 0 ){
            $whereQuery .= "where ";
        }
        if(isset($this->login)) {
            $whereQuery .= "mt_four_accounts.login like '%".$this->login."%'";
        }
        if(isset($this->email)) {
            if(isset($this->login)) {
                $whereQuery .= " AND ";
            }
            $whereQuery .= "mt_four_accounts.email_address like '%".$this->email."%'";
        }
        if(isset($this->agent)) {
            if(isset($this->login) || isset($this->email)) {
                $whereQuery .= " AND ";
            }
            $whereQuery .= "mt_four_accounts.agent like '%".$this->agent."%'";
        }
        if(isset($this->broker)) {
            if(isset($this->login) || isset($this->email) || isset($this->agent)) {
                $whereQuery .= " AND ";
            }
            $whereQuery .= "mt_four_accounts.broker_id IN (".implode(',',$this->broker).")";
        }
        
        if($this->priceStart > 0) {
            if(isset($this->login) || isset($this->email) || isset($this->agent) || isset($this->broker)) {
                $whereQuery .= " AND ";
            }
            $whereQuery .= "mt_four_accounts.balance BETWEEN ".$this->priceStart." AND ".$this->priceEnd."";

        }
        // dd($whereQuery);
        $sql = "select 
        IF(mt_four_accounts.login IS NULL or mt_four_accounts.login = '', '', mt_four_accounts.login) as login,
        mt_four_accounts.name ,
        mt_four_accounts.balance ,
        mt_four_accounts.equity ,
        IF(mt_four_accounts.email_address IS NULL or mt_four_accounts.email_address = '', '', mt_four_accounts.email_address) as email_address,
        mt_four_accounts.agent ,
        mt_four_accounts.brand ,
        mt_four_accounts.leverage ,
        mt_four_accounts.max_equity ,
        mt_four_accounts.max_balance ,
        IF(mt_four_brokers.name IS NULL or mt_four_brokers.name = '', '', mt_four_brokers.name) as broker_name
        from `mt_four_accounts` 
        LEFT JOIN mt_four_brokers ON mt_four_brokers.id = mt_four_accounts.broker_id 
        ".$whereQuery;
        // dd($sql);
        $finalData = DB::select($sql);
        
        return collect($finalData); 
    }
}
