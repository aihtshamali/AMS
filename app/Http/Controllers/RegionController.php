<?php

namespace App\Http\Controllers;
use App\Region;
use Illuminate\Http\Request;
use Session;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regions= Region::paginate(5);
        return view('region.index',compact('regions'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function excel()
    {
        return view('region.createThroughExcel');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('region.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
//            dd(count($dataImported[0]));
            foreach ($dataImported[0] as $d)
//                Region::insert($d);
                $region= new Region();
            $region->name= $d['name'];
            $region->type= $d['type'];
            $region->sub_name= $d['sub_name'];
            $region->account= $d['account'];
            $region->save();
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
        $region= new Region();
        $region->name= $request->name;
        $region->type= $request->type;
        $region->sub_name= $request->sub_name;
        $region->account= $request->account;
        $region->save();
        return redirect()->route('region.index')->withMessage('Inserted Successfully');
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
        $region=Region::find($id);
        return view('region.edit',compact('region'));
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

        $region= Region::find($id);
        $region->name= $request->name;
        $region->type= $request->type;
        $region->sub_name= $request->sub_name;
        $region->account= $request->account;
        $region->is_active= $request->is_active;

        $region->save();
        return redirect()->route('region.index')->withMessage('Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Region::find($id)->delete();
        return redirect()->route('region.index')->withMessage('Deleted Successfully');

    }
}
