@extends('layouts.backend.master')
@section('content')
<style>
    .icon__size{
        font-size: 16px;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h2 style="font-size: 23px;text-align: center">ALL REQUISITONS HISTORY</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                    
                        <ul class="nav nav-tabs nav-tabs-primary">
                            <li class="nav-item">
                              <a class="nav-link active" data-toggle="tab" href="#tabe-1"><span class="hidden-xs">All Requisitions</span></a>
                            </li>                       
                        </ul>
          
                          <!-- Tab panes -->
                          <div class="tab-content">
                            <div id="tabe-1" class="tab-pane active">
                              <div class="table-responsive">
                                  <table class="table table-bordered requisitionTable" style="width: 100% !important;">
                                      <thead>
                                          <tr>
                                              <th>User</th>
                                              <th>Description</th>
                                              <th>Type</th>
                                              <th>Payable Amount</th>
                                              <th>Date</th>
                                              <th>Status</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach($allRequisitions as $info)
                                                <tr>
                                                    <td>{{ $info->user->first_name." ".$info->user->last_name }}</td>
                                                    <td>{{ $info->description}}</td>
                                                    <td>{{ $info->type }}</td>
                                                    <td>{{ $info->payable_amount }}</td>
                                                    <td>{{ $info->date }}</td>
                                                    <td>
                                                        @if ($info->is_approved_by_inventory==1)
                                                            <i class="fa fa-check" style="color:#007bff"></i>
                                                        @else
                                                             <i class="fa fa-window-minimize"></i>
                                                        @endif

                                                        @if ($info->is_approved_by_supplychain==1)
                                                            <i class="fa fa-check" style="color:#007bff"></i>
                                                        @else
                                                             <i class="fa fa-window-minimize"></i>
                                                        @endif

                                                        @if ($info->is_approved_by_hop==1)
                                                            <i class="fa fa-check" style="color:#007bff"></i>
                                                        @else
                                                             <i class="fa fa-window-minimize"></i>
                                                        @endif
                                                                                                            
                                                        @if ($info->is_approved_by_ceo==1)
                                                            <i class="fa fa-check" style="color:#007bff"></i>
                                                        @else
                                                             <i class="fa fa-window-minimize"></i>
                                                        @endif                                                     
                                                        
                                                       
                                                    </td>
                                                </tr>
                                            @endforeach
                                      </tbody>
                                  </table>
                              </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function () {
        var table = $('.requisitionTable').DataTable({
            "aLengthMenu": [[ 10,50,100,500,1000,-1], [10,50,100,500,1000,"ALL"]],
            scrollY: 500,
            scrollX: true,
            scrollCollapse: true,
        });
    });
    
</script>
@endsection