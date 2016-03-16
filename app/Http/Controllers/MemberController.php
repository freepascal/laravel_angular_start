<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MemberRequest;
use App\Member;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;

use Session;
use Validator;
use Log;

class MemberController extends Controller
{
    private $request;

    // @get
    // list members
    public function index()
    {
        return Member::all();
    }

    // @get
    // create new member
    public function create()
    {
        return view('member.create');
    }

    // @post
    // save new member
    public function store(MemberRequest $request)
    {
        Log::info('pass validations ');
        $input = $request->all();
        $member = new Member();
        $member->name = $input['name'];
        $member->address = $input['address'];
        $member->age = $input['age'];

        if ($request->file()) {
            $member->photo = $this->upload_photo($request);
        }

        if ($member->save()) {
            Session::flash('message', array(
                'type'  => 'success',
                'text'  => 'Create new member successfully'
            ));
            return redirect()->route('member_list');
        }
    }

    public static function upload_photo($request)
    {
        $photo = $request->file('photo');
        $filename = $request->file('photo')->getClientOriginalName();
        Log::info("clientOriginalName: ". $filename);
        $saved_name = sprintf('up/%s-%s', time(), $filename);
        $path = public_path($saved_name);
        $size = '300,250';
        Log::info("realPath: ". $photo->getRealPath());
        Image::make($photo->getRealPath())->resize(intval($size), null, function ($contstraint) {
            $contstraint->aspectRatio();
        })->save($path);
        return $saved_name;
    }

    /*
    public function show($id)
    {
        $member = Member::find($id);
        return view('member.show', compact('member'));
    }

    //@get
    public function edit($id)
    {
        $member = Member::find($id);
        return view('member.edit', compact('member'));
    }
    */

    public function update(MemberRequest $request, $id)
    {
        $member = Member::find($id);
        $input = Input::all();
        $member->name = $input['name'];
        $member->address = $input['address'];
        $member->age = $input['age'];
        if ($request->file()) {
            $member->photo = $this->upload_photo($request);
        }
        //if ($member->save()) {
            $member->save();
            Session::flash('message', array(
                'type'  => 'success',
                'text'  => 'Update member successfully'
            ));
            return redirect()->route('member_list');
            //return \Response::make('ok', 200);
        //}
    }

    public function destroy($id)
    {
        $member = Member::find($id);
        $member->delete();
        //if ($member && $member->delete()) {
            return \Response::make('ok', 200);
        //}
    }
}
