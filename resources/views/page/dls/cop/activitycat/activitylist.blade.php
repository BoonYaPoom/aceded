@extends('layouts.adminhome')
@section('content')
 

$post=$this->input->post();
$datesearch=$post['datesearch'];
$startdate=$endate='';
if(!empty($datesearch)) {
	list($startdate,$enddate)=explode("-",$datesearch);
}

$js=' id="myform" name="myform"';
echo'<!-- Content Section -->
    <div class="bg-light">
      <div class="container space-1">
        <div class="card">
			<div class="card-header py-4 px-0 mx-4">';
			//echo form_open(base_url().$arg[1].'/'.$arg[2],$js,$hidden);
            echo'<!-- Activity Menu -->
            <div class="row justify-content-sm-between align-items-sm-center">
              <div class="col-md-5 col-lg-4 mb-2 mb-md-0">
					<button type="button" class="btn btn-sm btn-primary font-weight-semi-bold transition-3d-hover pointer" onclick="printDiv(\'printdatatable\');" ><i class="fa fa-print"></i> '.$this->lang->line("print").'</button>
              </div>

              <div class="col-md-6 ">
                <div class="d-flex">

                  <!-- Search -->';

                  echo'<div class="js-focus-state input-group input-group-sm">
                    <input id="datatableSearch" name="search" type="text" class="form-control" placeholder="'.$this->lang->line("search").'" aria-label="'.$this->lang->line("search").'" aria-describedby="search" value="'.$post['search'].'">
                  </div>
                  <!-- End Search -->
                </div>
              </div>
            </div>
            <!-- End Activity Menu -->
          </div>
          <div class="card-body  p-4">
            <!-- Activity Table -->
            <div id="printdatatable" class="table-responsive-md u-datatable">
              <table  class="js-datatable table table-borderless u-datatable__striped u-datatable__content u-datatable__trigger mb-5"
                     data-dt-info="#datatableInfo"
                     data-dt-search="#datatableSearch"
					 data-dt-button="#datatableButton"
                     data-dt-entries="#datatableEntries"
                     data-dt-page-length="'.$this->config->item('rowstable').'"
                     data-dt-is-responsive="false"
                     data-dt-is-show-paging="true"
                     data-dt-details-invoker=".js-datatabale-details"
                     data-dt-select-all-control="#invoiceToggleAllCheckbox"

                     data-dt-pagination="datatablePagination"
                     data-dt-pagination-classes="pagination mb-0"
                     data-dt-pagination-items-classes="page-item"
                     data-dt-pagination-links-classes="page-link"

                     data-dt-pagination-next-classes="page-item"
                     data-dt-pagination-next-link-classes="page-link"
                     data-dt-pagination-next-link-markup=\'<span aria-hidden="true">&raquo;</span>\'

                     data-dt-pagination-prev-classes="page-item"
                     data-dt-pagination-prev-link-classes="page-link"
                     data-dt-pagination-prev-link-markup=\'<span aria-hidden="true">&laquo;</span>\'>
                <thead>
                  <tr class="text-uppercase font-size-1">
                    
                    <th scope="col" class="font-weight-medium">
                      <div class="d-flex justify-content-between align-items-center">
                        '.$this->lang->line("order").'
                        <div class="ml-2">
                          <span class="fas fa-angle-up u-datatable__thead-icon"></span>
                          <span class="fas fa-angle-down u-datatable__thead-icon"></span>
                        </div>
                      </div>
                    </th>
                    <th scope="col" class="font-weight-medium">
                      <div class="d-flex justify-content-between align-items-center">
                        '.$this->lang->line("firstname").'-'.$this->lang->line("lastname").'
                        <div class="ml-2">
                          <span class="fas fa-angle-up u-datatable__thead-icon"></span>
                          <span class="fas fa-angle-down u-datatable__thead-icon"></span>
                        </div>
                      </div>
                    </th>

                    <th scope="col" class="font-weight-medium">
                      <div class="d-flex justify-content-between align-items-center">
                          '.$this->lang->line("status").'
                        <div class="ml-2">
                          <span class="fas fa-angle-up u-datatable__thead-icon"></span>
                          <span class="fas fa-angle-down u-datatable__thead-icon"></span>
                        </div>
                      </div>
                    </th>


                  </tr>
                </thead>
                <tbody class="font-size-1">';
				$n=0;
				foreach($activity_invite as $id => $row){
					$n++;

					if($row['status']==1) $invite_status=$this->lang->line("join");
					else if($row['status']==2) $invite_status=$this->lang->line("cancel");
					else $invite_status=$this->lang->line("not").$this->lang->line("confirm");

                  echo'<tr class="js-datatabale-details" >
                     <td class="align-middle text-secondary" width="10%">'.$n.'</td>
                    <td class="align-middle text-secondary font-weight-normal" width="75%">'.$row['firstname'].' '.$row['lastname'].'</td>
               
                    <td class="align-middle text-secondary" width="15%">
					 '.$invite_status.'
					</td>
                  
                  </tr>';
				  }
                  
                echo'</tbody>
              </table>
            </div>
            <!-- End Activity Table -->

            <!-- Pagination -->
            <div class="d-flex align-items-center">
              <nav id="datatablePagination" aria-label="Activity pagination"></nav>

              <small id="datatableInfo" class="text-secondary ml-auto"></small>
            </div>
            <!-- End Pagination -->
          </div>
        </div>
      </div>
    </div>
    <!-- End Content Section -->
	<div class="fixed-bottom space-2 mr-5 text-right border-1" > 
			<a class="text-secondary font-size-1" href="'.site_url('lms/add_activityform').'" > 
				<button type="button" class="btn btn-icon btn-danger btn-pill btn-xl transition-3d-hover shadow-xl">   
					 <i class="fas fa-pen btn-icon__inner"></i> 
				</button>    
			</a> 
	</div> 
	';


@endsection
