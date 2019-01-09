@extends('template')
@include('navtop')


@section('content')

	<div class="row" id="order">
		 <div class="col s12">
			 <ul class="tabs">
				 <li class="tab col s4"><a class="active" href="#test1">Orders</a></li>
				 <li class="tab col s4"><a href="#test2" id="get-pickup-order">Reward</a></li>
				 <li class="tab col s4"><a href="#test3" id="get-order-history">Collect in Store</a></li>
			 </ul>
		 </div>
		 <div id="test1" class="col s12">
			 <div class="row">
			 		 <p class="col s10"><a class="btn" id="get-new-order">check new order</a></p>
			 </div>

			 <div class="new-order blue lighten-4">

				 <ul class="collapsible" data-collapsible="expandable" id="order-info">
					 
				</ul>


			 </div>
		 </div>


		 <div id="test2" class="col s12">
			 <div class="row valign-wrapper center">
				 <div class="col s6 input-field">
					 <input id="email-for-voucher" type="text" class="validate">
           <label for="email-for-voucher">Customer's Email</label>
				 </div>
				 <div class="col s6">
				 	<button class="btn" id="search-voucher-by-email">Search Voucher</button>
				 </div>

			 </div>

			 <div class="voucher-results">

			 </div>
			</div>

		 <div id="test3" class="col s12">Test 3</div>
	 </div>









{{--
<div id="check-order">
	<p class="bold">Have incoming orders? please press the button below to check.</p>
	<button id="check_order" class="white-text orange waves-effect waves-light btn-small">Check New Orders</button>

		<table class="bordered highlight" id="order-info">
		    <thead>
		        <tr>
							<th >Reference</th>

			        <th >Email</th>
			        <th >Order Action</th>
							<th >Online Voucher</th>
							<th >Voucher Action</th>
		        </tr>
		    </thead>

		    <tbody id="new-order">

		    </tbody>
		</table>
</div> --}}



@endsection
