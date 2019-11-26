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
                                Liste de professeurs.
                            </div>
                        </div>
                    </a>

                    <a class="action border rounded" href="/commits">
                        <div class="action-logo">
                            <img src="{{ asset('images/commits.png') }}" alt="commits-logo" width="64" height="64">
                        </div>
                        <div class="action-body-container">
                            <div class="action-title">
                                Liste des commits
                            </div>
                            <div class="action-description">
                                Consulter la liste des commits mis en production par l'équipe.
                            </div>
                        </div>
                    </a>

                    <a class="action border rounded" href="/groupes">
                        <div class="action-logo">
                            <img src="{{ asset('images/groups.png') }}" alt="groupes-logo" width="64" height="64">
                        </div>
                        <div class="action-body-container">
                            <div class="action-title">
                                Groupes
                            </div>
                            <div class="action-description">
                                Liste des groupes.
                            </div>
                        </div>
                    </a>

                    <a class="action border rounded" href="/attributions">
                        <div class="action-logo">
                            <img src="{{ asset('images/attribution.png') }}" alt="attributions-logo" width="64"
                                height="64">
                        </div>
                        <div class="action-body-container">
                            <div class="action-title">
                                Attributions
                            </div>
                            <div class="action-description">
                                Liste des attributions.
                            </div>
                        </div>
                    </a>

                    <a class="action border rounded" href="/courses">
                        <div class="action-logo">
                            <img src="{{ asset('images/courses.png') }}" alt="courses-logo" width="64" height="64">
                        </div>
                        <div class="action-body-container">
                            <div class="action-title">
                                Cours
                            </div>
                            <div class="action-description">
                                Liste des cours.
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
                                Se déconnecter de votre compte.
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