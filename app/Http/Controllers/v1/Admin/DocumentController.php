<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Repositories\DistrictRepository;
use App\Repositories\DocumentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    private $documentRepository;

    public function __construct(
        DocumentRepository $documentRepository
    )
    {
        $this->documentRepository = $documentRepository;
    }

    public function list($id)
    {
        $documents = $this->documentRepository->with(['district'])->findWhere(['type_id' => $id])->toArray();
        $list = [];

        foreach($documents as $item) {
            $list[$item['district']['name']][] = [
                'id' => $item['id'],
                'file' => $item['file']
            ];
        }

        return responseData(true, ['list' => $list, 'params' => $this->params($id)]);
    }

    public function uploadFile($id, Request $request)
    {
        $data = $request->all();
        $districtRepository = app(DistrictRepository::class);
        $district = $districtRepository->firstOrCreate(['name' => $data['district']]);
        $documentRepository = app(DocumentRepository::class);


        $uploadedFile = $request->file('file');
        $filename = $uploadedFile->getClientOriginalName();
        $file = 'files/' . time() . '/'.$filename;

        Storage::disk('local')->putFileAs(
            $file,
            $uploadedFile,
            $filename
        );

        $documentRepository->create([
            'user_id' => auth()->user()->id,
            'district_id' => $district->id,
            'type_id' => $id,
            'file' => $file
        ]);

        return Storage::url($file);
    }

    public function deleteFile($id)
    {
        $file = Document::find($id);
        Storage::delete($file->file);
        $file->delete();

        return responseData(true);
    }

    public function params($id)
    {
        $regions = $this->regions();

        if($id == 3) {
            return [
                'Samarkand region' => $regions['Samarkand region'],
                'Tashkent city' => $regions['Tashkent city'],
            ];
        }

        return $regions;
    }

    public function regions()
    {
        return [
            'Republic of Karakalpakstan' => [
                'Amudarya district',
                'Beruniy district',
                'Nukus city',
                'Kanlikul district',
                'Karauzak district',
                'Kegeyli district',
                'Kungrat district',
                'Muynak district',
                'Nukus district',
                'Takhtakupir district',
                'Takhiyatash district',
                'Turtkul district',
                'Khodjayli district',
                'Chimbay district',
                'Shumanay district',
                'Ellikkala district'
            ],
            'Andijon region' => [
                'Altinkul district',
                'Andijan district',
                'Asaka district',
                'Balikchi district',
                'Boz district',
                'Bulakbashi district',
                'Andijan city',
                'Karasuv city',
                'Jalakuduk district',
                'Izboskan district',
                'Kurgantepa district',
                'Markhamat district',
                'Pakhtaadad district',
                'Ulugnar district',
                'Khojaabad district',
                'Shakhrikhan district'
            ],
            'Bukhara region' => [
                'Olot district',
                'Bukhara district',
                'Vobkent district',
                'Bukhara city',
                'Kogon city',
                'Gijduvan district',
                'Jondor district',
                'Kagan district',
                'Karakul district',
                'Karavulbazar district',
                'Peshku district',
                'Romitan district',
                'Shafirkan district'
            ],
            'Jizzakh region' => [
                'Arnasay district',
                'Bakhmal district',
                'Jizzakh city',
                'Gallaaral district',
                'Sh.Rashidov district',
                'Dustlik district',
                'Zomin district',
                'Zarbdor district',
                'Zafarobod district',
                'Mirzachul district',
                'Pakhtakor district',
                'Forish district',
                'Yangiabad district'
            ],
            'Kashkadarya region' => [
                'Karshi city',
                'Guzar district',
                'Dekhkanabad district',
                'Kamashi district',
                'Karshi district',
                'Koson district',
                'Kasbi district',
                'Kitab district',
                'Mirishkor district',
                'Muborak district',
                'Nishan district',
                'Chirakchi district',
                'Shakhrisabz district',
                'Yakkabog district'
            ],
            'Navoi region' => [
                'Zarafshan city',
                'Navoi city',
                'Karmana district',
                'Konimekh district',
                'Kiziltepa district',
                'Navbakhor district',
                'Nurota district',
                'Tomdi district',
                'Uchkuduk district',
                'Khatirchi district'
            ],
            'Namangan region' => [
                'Namangan city',
                'Kasansay district',
                'Mingbulak district',
                'Namangan district',
                'Norin district',
                'Pop district',
                'Turakurgan district',
                'Uychi district',
                'Uchkurgan district',
                'Chortok district',
                'Chust district',
                'Yangikurgan district'
            ],
            'Samarkand region' => [
                'Okdaryo district',
                'Bulung`ur district',
                'Kattakurgan city',
                'Samarkand city',
                'Jomboy district',
                'Ishtikhan district',
                'Kattakurgan district',
                'Kushrabad district',
                'Narpay district',
                'Nurobod district',
                'Payarik district',
                'Pastdargam district',
                'Pakhtachi district',
                'Samarkand district',
                'Toylok district',
                'Urgut district'
            ],
            'Surkhandarya region' => [
                'Oltinsoy district',
                'Angor district',
                'Boysun district',
                'Termiz city',
                'Denov district',
                'Jarkurgan district',
                'Kizirik district',
                'Kumkurgan district',
                'Muzrabad district',
                'Sariosiyo district',
                'Termez district',
                'Uzun district',
                'Sherabad district',
                'Shurchi district'
            ],
            'Sirdarya region' => [
                'Okoltin district',
                'Boyovut district',
                'Gulistan city',
                'Shirin ciy',
                'Yangier ciy',
                'Gulistan district',
                'Mirzaabad district',
                'Saykhunabad district',
                'Sardoba district',
                'Sirdarya district',
                'Khovos district'
            ],
            'Tashkent region' => [
                'Akkurgan district',
                'Okhangaran district',
                'Okhangaran city',
                'Bekobod city district',
                'Bustonlik district',
                'Olmalik city',
                'Angren city',
                'Bekobod city',
                'Chirchik city',
                'Zangiota district',
                'Kibray district',
                'Kuyichirchik district',
                'Parkent district',
                'Piskent district',
                'Tashkent district',
                'Nurafshan city',
                'Urtachirchik district',
                'Chinoz district',
                'Yukorichirchik district',
                'Yangiyul city',
                'Yangiyul district'
            ],
            'Fergana region' => [
                'Oltiarik district',
                'Bagdad district',
                'Besharik district',
                'Buvayda district',
                'Kokand city',
                'Kuvasay city',
                'Margilan city',
                'Fergana city',
                'Dangara district',
                'Quva district',
                'Qushtepa district',
                'Rishton district',
                'Sogd district',
                'Toshlok district',
                'Uzbekistan district',
                'Uchkuprik district',
                'Fergana district',
                'Furkat district',
                'Yozyovon district'
            ],
            'Khorazm region' => [
                'Bog`ot district',
                'Urganch city',
                'Gurlan district',
                'Kushkupir district',
                'Urganch district',
                'Khazorasp district',
                'Khonqa district',
                'Khiva city',
                'Khiva district',
                'Shovot district',
                'Yangiarik district',
                'Yangibozor district'
            ],
            'Tashkent city' => [
                'Olmazor district',
                'Bektemir district',
                'M.Ulugbek district',
                'Mirabad district',
                'Sergeli district',
                'Uchtepa district',
                'Yashnabad district',
                'Chilonzor district',
                'Shaykhontokhur district',
                'Yunusabad district',
                'Yakkasaray district'
            ]
        ];
    }
}
