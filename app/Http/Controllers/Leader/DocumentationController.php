<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\DocumentationPage;

class DocumentationController extends Controller
{
    /**
     * Display a listing of documentation pages.
     */
    public function index()
    {
        $pages = DocumentationPage::orderBy('order')->get();

        return view('leader.documentation.index', compact('pages'));
    }

    /**
     * Display the specified documentation page.
     */
    public function show(DocumentationPage $documentation)
    {
        $pages = DocumentationPage::orderBy('order')->get();
        $page = $documentation;

        return view('leader.documentation.show', compact('pages', 'page'));
    }
}
