<?php

namespace App\Http\Controllers;

use App\Faculty;
use App\Region;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faculties  = Faculty::paginate(7);
        return view('faculty.index',compact('faculties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regions=Region::all();
        return view('faculty.create',compact('regions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function excel()
    {
        return view('faculty.createThroughExcel');
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
            foreach ($dataImported[0] as $d)
                Customer::insert($d);
        }
        return back()->withMessage('Data Added Successfully');
    }


    public function store(Request $request)
    {
        $faculty = new Faculty();
        $faculty->name=$request->name;
        $faculty->father_name=$request->father_name;
        $faculty->type=$request->type;
        $faculty->region()->associate($request->region);
//        dd($faculty); TODO : This should not be HardCoded
        $faculty->user_id=5;
        $faculty->is_active=$request->is_active;
        $faculty->save();
        return redirect()->route('faculty.index')->withMessage('Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $regions=Region::all();
        return view('faculty.edit',compact(['faculty','regions']));
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

        $faculty = Faculty::find($id);
        $faculty->name=$request->name;
        $faculty->father_name=$request->father_name;
        $faculty->type=$request->type;
        $faculty->region()->associate($request->region);
//        dd($faculty); TODO This should not be HardCoded
        $faculty->user_id=5;
        $faculty->is_active=$request->is_active;
        $faculty->save();
        return redirect()->route('faculty.index')->withMessage('Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Faculty::destroy($id);
        return redirect()->route('faculty.index')->withMessage('Deleted Successfully');
    }
}
