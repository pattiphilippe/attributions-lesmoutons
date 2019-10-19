@extends('layout')

@section('title', 'Home')

@section('content')
<div id="dashboard-container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div id="actions-container">
                    <a class="action border rounded" href="/professeurs">
                        <div class="action-logo">
                            <img src="{{ asset('images/professor.png') }}" alt="professor-logo" width="64" height="64">
                        </div>
                        <div class="action-body-container">
                            <div class="action-title">
                                Professeurs
                            </div>
                            <div class="action-description">
                                Liste de professeurs
                            </div>
                        </div>
                    </a>

                    <a class="action border rounded" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <div class="action-logo">
                            <img src="{{ asset('images/logout.png') }}" alt="professor-logo" width="64" height="64">
                        </div>
                        <div class="action-body-container">
                            <div class="action-title">
                                Se déconnecter
                            </div>
                            <div class="action-description">
                                Se déconnecter de votre compte
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection