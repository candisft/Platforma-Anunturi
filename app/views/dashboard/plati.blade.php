@foreach($plati as $pay)
<tr {{ ($pay->suma > 0) ? 'class="plus"' : 'class="minus"' }} id="{{$pay->id}}"><td>{{$pay->id}}</td><td>{{$pay->suma}} &euro;</td><td>{{User::where('id', $pay->user)->first()->nume}}</a></td><td>{{$pay->pentru}}</td><td>{{$pay->created_at}}</td><td><div class="cat-dezactiveaza stergepay" title="Sterge Plata"></div></td></tr>
@endforeach