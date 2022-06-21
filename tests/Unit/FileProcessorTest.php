<?php

namespace R64\ContentImport\Tests\Unit;

use Illuminate\Http\File;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use League\Csv\MapIterator;
use R64\ContentImport\Processors\FileProcessor;
use R64\ContentImport\Tests\TestCase;

class FileProcessorTest extends TestCase
{

    /** @test */
    public function it_can_process_txt_files()
    {
        Storage::disk('local')->putFileAs('imports/1/', new File('tests/files/test_import.txt'), 'test_import.txt');

        $rows = (new FileProcessor())->read('imports/1/test_import.txt', '|');
        $outPut = collect($rows);


        $this->assertInstanceOf(MapIterator::class, $rows);

        $this->assertCount(2, $outPut);

        $this->assertEquals($outPut->first(), [
                "accountnumber" => "50451",
                "recipientname" => "  UNPOSTED CASH",
                "address1" => "SEE COMMENTS FOR",
                "address2" => "PAYMENTS NOT POSTED",
                "city" => "MADISON",
                "state" => "WI",
                "zip" => "",
                "balance" => "0.00",
                "removeaccount" => "Y",
                "client" => "42341",
                "clientname" => "STATE COLLECTION SERVICE",
                "consumeraccount" => "50451-",
                "clientmodel" => "",
                "clientaccountnumber" => "UC",
                "patientname" => "  UNPOSTED CASH",
                "duedate" => "",
                "admitdate" => "",
                "dischargedate" => "",
                "lastname" => "UNPOSTED CASH",
                "element1" => "",
                "totaldue" => "0.00",
                "paymenttypecode" => "",
                "fee" => "Y",
                "phase" => "50",
            ]
        );

        Storage::disk('local')->delete('imports/1/test_import.txt');
    }

    /** @test */
    public function it_can_process_txt_files_with_different_delimeters()
    {
        Storage::disk('local')->putFileAs('imports/1/', new File('tests/files/test_import_2.txt'), 'test_import_2.txt');

        $rows = (new FileProcessor())->read('imports/1/test_import_2.txt', '>');

        $outPut = collect($rows);

        $this->assertInstanceOf(MapIterator::class, $rows);

        $this->assertCount(2, $outPut);

        $this->assertEquals($outPut->first(), [
                "accountnumber" => "50451",
                "recipientname" => "  UNPOSTED CASH",
                "address1" => "SEE COMMENTS FOR",
                "address2" => "PAYMENTS NOT POSTED",
                "city" => "MADISON",
                "state" => "WI",
                "zip" => "",
                "balance" => "0.00",
                "removeaccount" => "Y",
                "client" => "42341",
                "clientname" => "STATE COLLECTION SERVICE",
                "consumeraccount" => "50451-",
                "clientmodel" => "",
                "clientaccountnumber" => "UC",
                "patientname" => "  UNPOSTED CASH",
                "duedate" => "",
                "admitdate" => "",
                "dischargedate" => "",
                "lastname" => "UNPOSTED CASH",
                "element1" => "",
                "totaldue" => "0.00",
                "paymenttypecode" => "",
                "fee" => "Y",
                "phase" => "50",
            ]
        );

        Storage::disk('local')->delete('imports/1/test_import_2.txt');
    }

    /** @test */
    public function it_can_process_csv_files()
    {
        Storage::disk('local')->putFileAs('imports/1/', new File('tests/files/test_import.csv'), 'test_import.csv');

        $rows = (new FileProcessor())->read('imports/1/test_import.csv', ',');

        $outPut = collect($rows);

        $this->assertInstanceOf(MapIterator::class, $rows);

        $this->assertCount(231, $outPut);

        $this->assertEquals($outPut->first(), [
                "recordtype" => "Account",
                "consumerfirstname" => "Test",
                "consumerlastname" => "Testfeild",
                "streetname" => "62 North Central Dr.",
                "city" => "Ofallon",
                "state" => "MO",
                "zipcode" => "63366",
                "last4ofssn" => "1111",
                "dateofbirth" => "",
                "filenumber" => "1000",
                "debtorid" => "44444",
                "originalaccountnumber" => "1000",
                "phonenumber" => "6363856698",
                "originalcreditorname" => "",
                "emailaddress" => "Drew.christmas@deltaoutsourcegroup.com",
                "accountbalance" => "110",
                "accountstatus" => "ACT",
                "producttype" => "00014 - BANK",
                "clientname" => "Old National Bank",
                "nextpaymentduedate" => "",
                "nextpaymentdueamount" => "",
                "lastpaymentdate" => "",
                "lastpaymentamount" => "0",
                "totalpaid" => "0",
                "paymentoption" => "0",
                "tokenid" => "LAT106801",
                "customerfield1" => "Old National Bank",
            ]
        );

        Storage::disk('local')->delete('imports/1/test_import_2.txt');
    }
}
