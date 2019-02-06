@extends('layouts.app')

@section('content')
<div class="container">
    
        @if($user->lga_id != null)
        <div class="alert alert-success h3" >{{$user->lga->name.' Local Governement 2019 Election Report'}}</div>
        <div class="row justify-content-center">
            @if(session('message'))
                {{session('message')}}
            @endif

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header h2">{{'Summary'}}</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Accredited</th>
                                    <th>APC</th>
                                    <th>PDP</th>
                                    <th>Other</th>
                                    <th>valid votes</th>
                                    <th>invalid votes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$summary['acredited']}}</td>
                                    <td>{{$summary['apc']}}</td>
                                    <td>{{$summary['pdp']}}</td>
                                    <td>{{$summary['other']}}</td>
                                    <td>{{$summary['valid_vote']}}</td>
                                    <td>{{$summary['invalid_vote']}}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>{{floor($summary['acredited']*100/$summary['acredited']) .'%'}}</td>
                                    <td>{{$summary['pdp']}}</td>
                                    <td>{{$summary['other']}}</td>
                                    <td>{{$summary['valid_vote']}}</td>
                                    <td>{{$summary['invalid_vote']}}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @foreach($user->lga->wards as $ward)
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header h3">{{$ward->name}}</div>
                      
                        <div class="card-body">
                            <div class="row">
                            @foreach($ward->pollingUnits as $pollingUnit)    
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">{{$pollingUnit->name}}</div>
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Accredited</th>
                                                        <th>APC</th>
                                                        <th>PDP</th>
                                                        <th>Other</th>
                                                        <th>valid</th>
                                                        <th>invalid</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{$pollingUnit->votes}}</td>
                                                        <td>{{$pollingUnit->result->apc}}</td>
                                                        <td>{{$pollingUnit->result->pdp}}</td>
                                                        <td>{{$pollingUnit->result->other}}</td>
                                                        <td>{{$pollingUnit->result->valid}}</td>
                                                        <td>{{$pollingUnit->result->invalid}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{floor($pollingUnit->votes/100*$pollingUnit->result->apc) .'%'}}</td>
                                                        <td>{{floor($pollingUnit->votes/100*$pollingUnit->result->pdp) .'%'}}</td>
                                                        <td>{{floor($pollingUnit->votes/100*$pollingUnit->result->other) .'%'}}</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            @if($pollingUnit->votes == 0 && $pollingUnit->result->apc == 0)
                                            <form action="/add_result" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$pollingUnit->id}}">
                                                <input type="submit" class="btn btn-primary" value="Insert Result" >
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach 
                            </div>   
                        </div>
                    </div>
                </div>
        
            @endforeach
        </div>
        @else
        <div class="row justify-content-center">
            <div class="alert alert-success h4" >{{$user->pollingUnit->name.' APC Agent'}}</div>
            @if($user->PollingUnit->votes == 0)
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header h3">How many Voters are accredated</div>

                    <div class="card-body">
                        <form action="/accredited" method="post">
                            @csrf
                            <input class="form-control" type="text" name="votes" placeholder="number of accredated voters"><br>
                            <input type="submit" class="btn btn-primary" value="Send">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header h3">Report incidence</div>

                    <div class="card-body">
                        <form action="#" method="post">
                            @csrf
                            <button class="btn btn-danger btn-block">Violence</button>
                            <button class="btn btn-danger btn-block">Valot Snatching</button>
                            <button class="btn btn-danger btn-block">Vote Saling</button>
                            <button class="btn btn-danger btn-block">Vote Buying</button>
                            <button class="btn btn-danger btn-block">Absence of Security</button>
                            <button class="btn btn-danger btn-block">Late Arrival Of Material Or Staff</button>
                        </form>
                    </div>
                </div>
            </div>
           @elseif($user->pollingUnit->result->apc == 0)
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header h3">Send Result</div>

                    <div class="card-body">
                        <form action="/result" method="post">
                            @csrf
                            <input class="form-control" type="text" name="apc" placeholder="APC"><br>
                            <input class="form-control" type="text" name="pdp" placeholder="PDP"><br>
                            <input class="form-control" type="text" name="other" placeholder="OTHER"><br>
                            <input class="form-control" type="text" name="valid_vote" placeholder="VALID VOTE"><br>
                            <input class="form-control" type="text" name="invalid_vote" placeholder="INVALID VOTE"><br>
                            <input type="submit" class="btn btn-primary" value="Send">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header h3">Report incidence</div>

                    <div class="card-body">
                        <form action="#" method="post">
                            @csrf
                            <button class="btn btn-danger btn-block">Violence</button>
                            <button class="btn btn-danger btn-block">Valot Snatching</button>
                            <button class="btn btn-danger btn-block">Vote Saling</button>
                            <button class="btn btn-danger btn-block">Vote Buying</button>
                            <button class="btn btn-danger btn-block">Absence of Security</button>
                            <button class="btn btn-danger btn-block">Late Arrival Of Material Or Staff</button>
                        </form>
                    </div>
                </div>
            </div>
            @else
                <div class="alert alert-success h4" >{{'Thanks for using our Applictaion in 2019 '}}</div>  
            @endif
        </div>    
        @endif
</div>
@endsection
