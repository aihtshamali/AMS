<?php

namespace App\Http\Controllers;
use App\City;
use App\Region;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities= City::paginate(7);
        $regions=Region::all();
        return view('city.index',compact(['cities']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regions=Region::all();
       return view('city.create',compact('regions'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function excel()
    {
        return view('city.createThroughExcel');
    }

    public function import(Request $request)
    {
//        dd($request->all())
        if($request->file('imported-file'))
        {
            $path = $request->file('imported-file')->getRealPath();
//           dd( $path);
            $data = \Maatwebsite\Excel\Facades\Excel::load($path, function($reader) {
            })->get();
//            dd($data);
            if(!empty($data) && $data->count())
            {
                $data = $data->toArray();
                for($i=0;$i<count($data);$i++)
                {
                    $dataImported[] = $data[$i];
                }
            }
//            dd($dataImported[0]);
            foreach ($dataImported[0] as $d) {
                $city= new City();
//                dd($d);
                $city->name=$d['name'];
                $city->description=$d['description'];
                $city->region()->associate(Region::where('name',$d['region_name'])->first());
                $city->save();

            }
//                City::insert($d);
        }
        return back()->withMessage('Data Added Successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $city= new City();
        $city->name= $request->name;
        if( $request->regions!="No Location") {
            $city->region_id = $request->regions;
            $city->region()->associate($request->regions);
        }
        $city->save();
        return redirect()->route('city.index')->withMessage('Inserted Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        City::find($id)->delete();
        $city= new City();
        $city->name= $request->name;
        $city->region= $request-region;
        $city->save();
        return redirect()->route('city.index')->withMessage('Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        City::find($id)->delete();
        return redirect()->route('city.index')->withMessage('Deleted Successfully');

    }
}
