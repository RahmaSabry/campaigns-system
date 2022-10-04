<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignStoreRequest;
use App\Models\Campaign;
use App\Models\Image;
use Illuminate\Http\Request;
use Carbon\Carbon;
class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaigns = Campaign::with('images')->get();
        return view('campaigns.list',compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('campaigns.form');
        // return response()->json(['hello from create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CampaignStoreRequest $request)
    {
        $data = $request->toArray();
        $dates = explode(',',$data['date']);
        $data['from'] = $dates[0];
        $data['to'] = $dates[1];
        $campaign = Campaign::create($data);
        $this->storeImages($request->images, $campaign->id);
       
        return response(['message' => 'Campaign is Created'], 201);
      
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
        $campaign = Campaign::with('images')->where('id',$id)->first();
        return view('campaigns.form',compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campaign)
    {
        $oldImages = Image::where('campaign_id', $campaign->id)->get();
        $newImages = $request->images;
        $data = $request->toArray();
        $dates = explode(',',$data['date']);
        $data['from'] = $dates[0];
        $data['to'] = $dates[1];
        $campaign->update($data);
        $newImages = $this->filterNewImages($newImages, $oldImages);
        $this->storeImages($newImages, $campaign->id);

        return response(['message' => 'Campaign is Updated'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function storeImages($images, $campaign_id)
    {
        if($images)
        {
            foreach ($images as $image)
            {
                $data = [];
                $image->store('public/images');
                $data['name'] = $image->hashName();
                $data['original_name'] = $image->getClientOriginalName();
                $data['campaign_id'] = $campaign_id;
                Image::create($data);
            }
        }
        
    }

    public function filterNewImages($newImages, $oldImages)
    {
        $currentImages = array();
        if(isset($newImages))
        {
            foreach($newImages as $key => $newImage)
            {
                if(gettype($newImage) == 'string')
                {
                    $currentImages[] = json_decode($newImage);
                    array_splice($newImages, $key, 1);
                }
            }
        }
        
        if(isset($oldImages))
        {
            foreach($oldImages as $oldImage)
            {
                if(!$this->isImageExist($currentImages, $oldImage)) $oldImage->delete();
            }
        }
        
        return $newImages;
    }

    public function isImageExist($currentImages, $oldImage)
    {
        array_filter(
            $currentImages,
            function ($e) use (&$oldImage) 
            {
                return $e->id == $oldImage->id;
            });
    }
}
