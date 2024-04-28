<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ModulController extends Controller
{
    public $folder = "modul";
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->getMenu();
        $menu = $this->printRecursiveMenu(json_decode($data), false);
        $folder = $this->folder;
        return view('settings.modul.index', compact('menu', 'folder'));
    }

    public function getMenu()
    {
        $status = [
            'config_modul' => "settings",
        ];
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken($_COOKIE['access-token'])
            ->get(config('app.api_url') . 'getmenu', $status);

        return $response;
    }


    public function printRecursiveMenu(array $menus, bool $hasParent = false)
    {
        $string = $hasParent ? '<ul class="nav nav-treeview">' : '';
        foreach ($menus as $menu) {
          if (count($menu->child) > 0 || $menu->link != '') {
            $string .= '
              <li class="nav-item">
                <a href="' . (count($menu->child) > 0 ? 'javascript:void(0)' :strtolower(url("admin/".$menu->link))) . '" class="nav-link">
                  <i class="nav-icon ' . (strtolower($menu->menu_icon) ?? 'far fa-circle') . '"></i>
                  <p>
                    ' . $menu->urutan . '. ' . $menu->menu_name . '
                    ' . (count($menu->child) > 0 ? '<i class="right fas fa-angle-left"></i>' : '') . '
                  </p>
                </a>
                ' . (count($menu->child) > 0 ? $this->printRecursiveMenu($menu->child, true) : '') . '
              </li>
            ';
          }
        }

        $string .= $hasParent ? '</ul>' : '';

        return $string;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
