  <h3 class="text-white-40" id="layer"> RECADOS ANTERIORES</h3>
                <br>
                @if($Recados->count()==0)
                <p> Aún no hay recados para mostrar </p>
                @else
                <table class="table text-xl ">
                    <thead>
                        <tr>
                            <th>Recado</th>
                            <th>Status</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th><i class="fas fa-user"></i></th>
                            <th style=" width: 7%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($Recados as $r)
                            @if($r->tel_id == $telefono->id)
                            <tr style="background-color: {{$r->color_rgb}};">
                                <td> {{$r->recado}} </td>
                                <td> {{$r->description}} </td>
                                <td> {{$r->type}} </td>
                                <td> {{$r->fecha}} </td>
                                <td> {{substr($r->user_name,0,10)}} </td>
                                <td > 
                                    @can('borrar_recado')
                                    <form method="POST"  class="DeleteReg" action="{{ route('recados.destroy', $r->id) }}">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">

                                        <button type="submit" class="btn btn-danger btn-lg"  title='Delete'> <i class="fa fa-trash" aria-hidden="true"></i> </button>
                                    </form>  
                                    @endcan
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                @endif