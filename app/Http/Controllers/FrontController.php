<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\CompanyAbout;
use App\Models\CompanyStatistic;
use App\Models\HeroSection;
use App\Models\OurPrinciple;
use App\Models\OurTeam;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index()
    {
        $hero_section = HeroSection::first();
        $statistics = CompanyStatistic::take(4)->get();
        $principles = OurPrinciple::take(3)->get();
        $products = Product::take(3)->get();
        $teams = OurTeam::take(3)->get();
        $testimonials = Testimonial::take(5)->get();
        return view('front.index', compact('hero_section', 'statistics', 'principles', 'products', 'teams', 'testimonials'));
    }

    public function team()
    {
        $teams = OurTeam::get();
        $statistics = CompanyStatistic::take(4)->get();
        return view('front.team', compact('teams', 'statistics'));
    }

    public function about()
    {
        $about_vision = CompanyAbout::where('type', 'Visions')->first();
        $about_mission = CompanyAbout::where('type', 'Missions')->first();
        return view('front.about', compact('about_vision', 'about_mission'));
    }

    public function appointment()
    {
        $testimonials = Testimonial::take(5)->get();
        $products = Product::get();
        return view('front.appointment', compact('testimonials', 'products'));
    }

    public function appointment_store(StoreAppointmentRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();
            $newAppointment = Appointment::create($validated);
        });

        return redirect()->route('front.index');
    }
}
