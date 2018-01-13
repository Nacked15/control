<?php

class PagosModel
{
	public static function getPaylist($lista) {
		$alumnos = GeneralModel::students($lista);

		if ($alumnos !== false) {
			self::showPayList($alumnos, $lista);
		} else {
			echo '<h4 class="text-center text-info subheader">
					No hay lista de pagos en este grupo.
				  </h4>';
		}
	}

	public static function showPayList($alumnos, $lista){
        echo '<div class="table">';
            echo '<table id="tbl_paylist_'.$lista.'"
                         class="table table-bordered table-hover table-striped table-condensed">';
                echo '<thead>';
                    echo '<tr class="info">';
                        echo '<th class="text-center">Alumno</th>';
                        echo '<th class="text-center">Datos</th>';
                        echo '<th class="text-center">Ago</th>';
                        echo '<th class="text-center">Sep</th>';
                        echo '<th class="text-center">Oct</th>';
                        echo '<th class="text-center">Nov</th>';
                        echo '<th class="text-center">Dic</th>';
                        echo '<th class="text-center">Comentario</th>';
                        echo '<th class="text-center">Opciones</th>';
                    echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                foreach ($alumnos as $alumno) {
                	echo '<tr class="row_data">';
	                    echo '<td class="text-center tiny">'.$alumno->nombre.'</td>';
	                    echo '<td class="text-center tiny"></td>';
	                    echo '<td class="text-center tiny">';
                                echo '<a href="javascript:void(0)" class="check_pay">
                                        <i class="mdi-action-done"></i>
                                      </a>';
                        echo '</td>';
	                    echo '<td class="text-center tiny">';
                                echo '<a href="javascript:void(0)" class="check_pay">
                                        <i class="mdi-action-done"></i>
                                      </a>';
                        echo '</td>';
	                    echo '<td class="text-center tiny">';
                                echo '<a href="javascript:void(0)" class="check_pay">
                                        <i class="mdi-action-done"></i>
                                      </a>';
                        echo '</td>';
	                    echo '<td class="text-center tiny">';
                                echo '<a href="javascript:void(0)" class="check_pay">
                                        <i class="mdi-action-done"></i>
                                      </a>';
                        echo '</td>';
	                    echo '<td class="text-center tiny">';
                                echo '<a href="javascript:void(0)" class="check_pay">
                                        <i class="mdi-action-done"></i>
                                      </a>';
                        echo '</td>';
	                    echo '<td class="text-center tiny">Comentario</td>';
	                    echo '<td class="text-center tiny">';
	                    echo '<div class="btn-group">';
	                        echo '<a href="javascript:void(0)"
	                                 class="btn btn-main btn-xs btn-raised">Pagar
	                              </a>';
	                    echo '</div>';
	                    echo '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '<tfoot>';
                echo '<tr>';
                echo '<td class="text-center">
                        <button type="button" class="btn btn-xs mini btn-second change_multi">
                            Adeudos
                        </button>
                      </td>';
                echo '<td class="text-center">
                        <button type="button" class="btn btn-xs mini btn-warning tekedown_multi">
                            Becados
                        </button>
                      </td>';
                echo '<td class="text-center"></td>';
                echo '<td class="text-center"></td>';
                echo '<td class="text-center"></td>';
                echo '<td class="text-center"></td>';
                echo '<td class="text-center"></td>';
                echo '<td class="text-center"></td>';
                echo '<td class="text-center"></td>';
                echo '</tr>';
                echo '</tfoot>';
            echo '</table>';
            echo "<br><br><br>";
        echo '</div>';
	}
}
