<?php

use App\Mail\TestMail;
use App\Models\Setting;

if (!function_exists('all_lang')) {
    function all_lang(){
        $langs = [];
        $dir    = 'resources/lang/';
        $files = array_diff(scandir($dir), array('..', '.'));
        foreach ($files  as $x => $lang){
            $lang_files = array_diff(scandir($dir.$lang), array('..', '.'));
            foreach ($lang_files as $y => $file){
                foreach (include($dir.$lang."/".$file) as $z => $v) {
                    $f = str_replace(".php", "", $file);
                    $langs[$lang][$f][$z] = $v;
                }
            }
        }
        return $langs;
    }
}

if (!function_exists('mailit')) {
    function mailit($to, $subject, $body,  $system = "Settings", $attachments = null, $from = null)
    {
        try {
            init();
            Mail::to($to)->send(new TestMail($subject, $body, $attachments, $from));
            /*$archive = new Archive;
            $archive->company_id = $company_id;
            $archive->daftar = $daftar;
            $archive->user = $to;
            $archive->type = 0;
            $archive->message = $body;
            $archive->attachment = ($attachment and is_array($attachment))? implode(";", $attachment) : null;
            $archive->save();*/
            /*\Mail::send([], [], function ($message) use ($to, $subject, $body) {
                $message->to($to)
                    ->subject($subject)
                    ->setBody($body, 'text/html');
            });*/
        } catch (\Exception $e) {
            dd($e->getMessage());
            //dd(config("mail"));
        }
    }
}

if (!function_exists('init')) {
    function init()
    {
        $csettings = Setting::all()->keyBy("key");

        $app_name = (@$csettings["app_name"]) ? @$csettings["app_name"]->value : "SimpleERP";
        $email_sent_from_address = @$csettings["smtp_username"]->value;
        $email_sent_from_name = $app_name;
        $email_smtp_host = @$csettings["smtp_host"]->value;
        $email_smtp_user = @$csettings["smtp_username"]->value;
        $email_smtp_password = @$csettings["smtp_password"]->value;
        $email_smtp_port = @$csettings["smtp_port"]->value;
        $encryption = @$csettings["smtp_security_type"]->value;
        Config::set('app.name', $email_sent_from_name);
        Config::set('mail.from.name', '"' . $email_sent_from_name . '"');
        Config::set('mail.from.address', $email_sent_from_address);

        if ($email_smtp_host and $email_smtp_user and $email_smtp_password and $email_smtp_port and $encryption) {
            Config::set('mail.mailers.smtp.host', $email_smtp_host);
            Config::set('mail.mailers.smtp.port', $email_smtp_port);
            Config::set('mail.mailers.smtp.username', $email_smtp_user);
            Config::set('mail.mailers.smtp.password', $email_smtp_password);
            Config::set('mail.mailers.smtp.encryption', $encryption);
        }
    }
}

if (!function_exists('main_sectors')) {
    function main_sectors()
    {
        return ["Commerce", "Education", "Entertainment", "Construction",
            "Chemical Industries", "Basic Metal Production", "Financial Services", "Food, Drink & Tobacco",
            "Forestry, Wood, Pulp and Paper", "Health Services", "Hotels, Tourism & Catering", "Mining",
            "Mechanical/Electrical Engineering", "Media, Culture, Graphical", "Oil & Gas Production", "Postal & Telecommunication",
            "Public Service", "Shipping, Ports, Fisheries, Inland Waterways", "Textiles, Clothing, Leather, footwear",
            "Transport", "Transport Equipment Manufacturing", "Utilities (Water, Gas, Electricity)", "Agriculture, Plantations & Other Rural Sectors", "Other"];
    }
}
