
			<table class="table table-striped table-hover" style="text-align: center"  id="MainTable"> 
				<thead>
					<tr>
						<th>name</th>
                        <th>description</th>
                        <th>discount</th>
						<th>price before discount</th>
						<th>price after discount</th>
                        <th>category type</th>
                        <th>points</th>
						<th>image link </th>
                        <th>usage</th>
                        <th>approved </th>
                        <th>branches</th>
						<th>edit</th>
						<th>delete</th>

					</tr>
				</thead>
				<tbody>
		
					@foreach($offers as $offer)				
					<tr data-id={{$offer->id}} data-branches="{{$offer->branches_name}}" data-type="{{$offer->type}}" data-duration="{{$offer->duration}}">
                        <td class="name">{{$offer->name}}</td>
                        <td class="description">{{$offer->description}}</td>
						<td class="discount">{{$offer->discount}}</td>
                        <td class="price_before_discount">{{$offer->price_before_discount}}</td>
						<td class="price_after_discount">{{$offer->price_after_discount}}</td>
						<td class="category_type">{{$offer->category_type}}</td>
						<td class="points">{{$offer->points}}</td>
                        <td class="image"><img src="{{asset("offers-photos/".$offer->image_link)}}" style="max-width:70px"></td>

                        <td class="usage">{{$offer->usage}}</td>
                        <td class="approved">{{$offer->get_approved_state()}}</td>
                        <td class="branches_name">
						    @foreach ($offer->get_branches() as $branches)
							{{$branches}}
							<br>
							@endforeach
						</td>
						<td ><i class="fa fa-pencil-square-o edit_row" href="#EditOfferModal"  data-toggle="modal" aria-hidden="true"></i></td>
						<td><i class="fa fa-trash-o delete_row" data-toggle="modal" href="#DeleteOfferModal" aria-hidden="true"></i></td>
					</tr> 
					@endforeach
				</tbody>
			</table>