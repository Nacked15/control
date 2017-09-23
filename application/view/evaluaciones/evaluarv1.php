<div class="col-sm-10 col-sm-offset-1">
    <h3 class="text-center text-primary">HOJA DE EVALUACIÓN</h3>
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 text-center" style="margin-bottom: 5px;">
            <div class="form-group">
                <label class="col-md-3 text-right">Tema:</label>
                <div class="col-md-9">
                    <input type="hidden" id="id_task" name="evento_id" class="form-control">
                    <input type="text" id="edit_date_todo" name="fecha_evento" class="form-control" required="true">
                </div>
            </div>
        </div>
    </div>
    <h5 class="text-center"><strong>Tema:</strong> The Numbers</h5>
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr class="tb_purple">
                <th>Achievement</th>
                <th class="text-center">Excellent (Excelente)</th>
                <th class="text-center">Good (Bueno)</th>
                <th class="text-center">Average (Regular)</th>
                <th class="text-center">Weak (Bajo)</th>
                <th class="hidden">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Reading</td>
                <td class="text-center"><span class="fa fa-star checked"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="hidden"><input type="text" id="reading" class="form-control" value="0"></td>
            </tr>
            <tr>
                <td>Writing</td>
                <td class="text-center"><span class="fa fa-star checked"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="hidden"><input type="text" id="writing" class="form-control" value="0"></td>
            </tr>
            <tr>
                <td>Speaking</td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star checked"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="hidden"><input type="text" id="speaking" class="form-control" value="0"></td>
            </tr>
            <tr>
                <td>Listening</td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star checked"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="hidden"><input type="text" id="listening" class="form-control" value="0"></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr class="tb_purple">
                <th>Effort</th>
                <th class="text-center">Excellent (Excelente)</th>
                <th class="text-center">Good (Bueno)</th>
                <th class="text-center">Average(Regular)</th>
                <th class="text-center">Weak (Bajo)</th>
                <th class="hidden">Puntos</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Reading</td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="hidden"><input type="text" id="read" class="form-control" value="0"></td>
            </tr>
            <tr>
                <td>Writing</td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="hidden"><input type="text" id="write" class="form-control" value="0"></td>
            </tr>
            <tr>
                <td>Speaking</td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="hidden"><input type="text" id="speak" class="form-control" value="0"></td>
            </tr>
            <tr>
                <td>Listening</td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="hidden"><input type="text" id="listen" class="form-control" value="0"></td>
            </tr>
            <tr>
                <td>Participation.</td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="hidden"><input type="text" id="attitude" class="form-control" value="0"></td>
            </tr>
            <tr>
                <td>Teamwork.</td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="hidden"><input type="text" id="team" class="form-control" value="0"></td>
            </tr>
            <tr>
                <td>Homeworks</td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="text-center"><span class="fa fa-star"></span></td>
                <td class="hidden"><input type="text" id="time" class="form-control" value="0"></td>
            </tr>
        </tbody>
    </table>

    <div class="row">
        <div class="col-sm-12 text-center" style="margin-bottom: 5px;">
            <div class="form-group">
                <label>Comentario:</label>
                <textarea id="edit_event" name="event" rows="8" class="form-control texto" placeholder="Escriba alguna observación en este espacio..."></textarea>
            </div>
        </div>
    </div>
</div>