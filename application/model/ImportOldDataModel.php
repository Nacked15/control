<?php

class ImportOldDataModel
{
	public static function importStudents() {
		$database = DatabaseFactory::getFactory()->getConnection();
		$query = $database->prepare("SELECT * FROM naatikdb.student;");
		$query->execute();
		$students = array();
		if ($query->rowCount() > 0) {
			$alumnos = $query->fetchAll();
			$count = 1;
			foreach ($alumnos as $alumno) {
				$students[$alumno->id_student] = new stdClass();
				$students[$alumno->id_student]->count        = $count++;
				$students[$alumno->id_student]->name         = ucwords(strtolower($alumno->name_s));
				$students[$alumno->id_student]->surname      = ucwords(strtolower($alumno->surname1_s));
				$students[$alumno->id_student]->lastname     = ucwords(strtolower($alumno->surname2_s));
				$students[$alumno->id_student]->birthdate    = $alumno->birthday;
				$students[$alumno->id_student]->age          = $alumno->age;
				$students[$alumno->id_student]->genre        = $alumno->sexo;
				$students[$alumno->id_student]->civil_status = $alumno->edo_civil;
				$students[$alumno->id_student]->cellphone    = $alumno->cellphone;
				$students[$alumno->id_student]->reference    = $alumno->reference;
				$students[$alumno->id_student]->isckness     = $alumno->sickness;
				$students[$alumno->id_student]->medication   = $alumno->medication;
				$students[$alumno->id_student]->avatar       = $alumno->photo_s;
				$students[$alumno->id_student]->description  = $alumno->comment_s;
				$students[$alumno->id_student]->homestay     = $alumno->homestay;
				$students[$alumno->id_student]->status       = $alumno->status;
				$students[$alumno->id_student]->tutor        = self::getTutor($alumno->id_tutor);
				$students[$alumno->id_student]->ubication    = self::getUbicationAddress($alumno->id_tutor);
				$students[$alumno->id_student]->academic_data = self::getAcademicInfo($alumno->id_student);
				$students[$alumno->id_student]->details       = self::getExtraInfo($alumno->id_student);
				$students[$alumno->id_student]->pay_data      = self::getPayHistoric($alumno->id_student);
				$students[$alumno->id_student]->scholar_data  = self::getBecasHistoric($alumno->id_student);
			}

			return $students;
		}
	}

	public static function getTutor($tutor){
		$database = DatabaseFactory::getFactory()->getConnection();
		$query = $database->prepare("SELECT * FROM naatikdb.tutor 
									 WHERE id_tutor = :tutor
									   AND name_t != 'N/A'
									   AND surname1_t != 'N/A'
									   AND surname2_t != 'N/A'
									   AND phone != 'S/N' 
									 LIMIT 1;");
		$query->execute(array(':tutor' => $tutor));

		$datos = array();
		if ($query->rowCount() > 0) {
			$tutor = $query->fetch();
			$datos[$tutor->id_tutor]  =  new stdClass();
			$datos[$tutor->id_tutor]->id           = $tutor->id_tutor;
			$datos[$tutor->id_tutor]->name         = ucwords(strtolower($tutor->name_t));
			$datos[$tutor->id_tutor]->surname      = ucwords(strtolower($tutor->surname1_t));
			$datos[$tutor->id_tutor]->lastname     = ucwords(strtolower($tutor->surname2_t));
			$datos[$tutor->id_tutor]->job          = $tutor->job;
			$datos[$tutor->id_tutor]->phone        = $tutor->phone;
			$datos[$tutor->id_tutor]->cellphone    = $tutor->cellphone_t;
			$datos[$tutor->id_tutor]->phone_alt    = $tutor->phone_alt;
			$datos[$tutor->id_tutor]->relationship = $tutor->relationship;
			$datos[$tutor->id_tutor]->relationship_alt = $tutor->relationship_alt;
			$addr = explode(',', $tutor->address_t);
			$datos[$tutor->id_tutor]->street  = $addr[0];
			$datos[$tutor->id_tutor]->number  = $addr[1];
			$datos[$tutor->id_tutor]->between = $addr[2];
			$datos[$tutor->id_tutor]->colony  = $addr[3];
		}

		return $datos;
	}

	public static function getUbicationAddress($user){
		$database = DatabaseFactory::getFactory()->getConnection();
		$query = $database->prepare("SELECT lat as latitud, long as longitud
									 FROM naatikdb.croquis 
									 WHERE idtutor = :tutor LIMIT 1;");
		$query->execute(array(':tutor' => $user));

		if ($query->rowCount() > 0) {
			return $query->fetch();
		}

		return false;
	}

	public static function getAcademicInfo($student) {
		$database = DatabaseFactory::getFactory()->getConnection();

		$query = $database->prepare("SELECT *
									 FROM naatikdb.academic_info
									 WHERE id_student = :student
									 LIMIT 1");
		$query->execute(array(':student' => $student));
		$data = array();
		if ($query->rowCount() > 0) {
			$info = $query->fetch();
			$data[$info->id_student] = new stdClass();
			$data[$info->id_student]->ocupation    = $info->ocupation;
			$data[$info->id_student]->studies      = $info->studies;
			$data[$info->id_student]->level        = $info->level;
			$data[$info->id_student]->prior_course = $info->prev_course;
			$data[$info->id_student]->sep          = self::getSEPInfo($info->reg_sep);
			$data[$info->id_student]->date_init    = $info->date_init_s;
			$date_baja   = $info->date_bajaSt === '0000-00-00' ? NULL : $info->date_bajaSt;
			$data[$info->id_student]->date_baja    = $date_baja;
			$date_egreso = $info->date_egreso === '0000-00-00' ? NULL : $info->date_egreso;
			$data[$info->id_student]->date_egreso  = $date_egreso;
		}

		return false;
	}

	public static function getSEPInfo($id_sep){
		$database = DatabaseFactory::getFactory()->getConnection();
		$query = $database->prepare("SELECT * FROM naatikdb.sep 
									 WHERE id_sep = :sep AND issep = 'si' LIMIT 1;");
		$query->execute(array(':sep' => $id_sep));

		if ($query->rowCount() > 0) {
			return $query->fetch();
		}
		return false;
	}

	public static function getExtraInfo($student) {
		$database = DatabaseFactory::getFactory()->getConnection();

		$query = $database->prepare("SELECT reg_nacimiento as acta, convenio, facturacion
									 FROM naatikdb.info_extrast
									 WHERE id_st = :student
									 LIMIT 1");
		$query->execute(array(':student' => $student));
		if ($query->rowCount() > 0) {
			return $query->fetch();
		}

		return false;
	}

	public static function getPayHistoric($student){
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = $database->prepare("SELECT * FROM naatikdb.pays WHERE id_student = :student;");
		$sql->execute(array(':student' => $student));

		$data = array();
		if ($sql->rowCount() > 0) {
			$pagos = $sql->fetchAll();
			foreach ($pagos as $pago) {
				$data[$pago->id_pay] = new stdClass();
				$data[$pago->id_pay]->ene = $pago->jan;
				$data[$pago->id_pay]->feb = $pago->feb;
				$data[$pago->id_pay]->mar = $pago->mar;
				$data[$pago->id_pay]->abr = $pago->apr;
				$data[$pago->id_pay]->may = $pago->may;
				$data[$pago->id_pay]->jun = $pago->jun;
				$data[$pago->id_pay]->jul = $pago->jul;
				$data[$pago->id_pay]->ago = $pago->aug;
				$data[$pago->id_pay]->sep = $pago->sep;
				$data[$pago->id_pay]->oct = $pago->oct;
				$data[$pago->id_pay]->nov = $pago->nov;
				$data[$pago->id_pay]->dic = $pago->dece;
				$data[$pago->id_pay]->anio = $pago->year_pay;
				$data[$pago->id_pay]->ciclo = $pago->ciclo;
				$data[$pago->id_pay]->becado = $pago->becado;
				$data[$pago->id_pay]->comentario = $pago->comment;
			}
		}

		return $data;
	}

	public static function getBecasHistoric($student){
		$database = DatabaseFactory::getFactory()->getConnection();

		$sql = $database->prepare("SELECT request, togrant, date_scholar 
								   FROM naatikdb.scholar
								   WHERE id_student = :student;");
		$sql->execute(array(':student' => $student));

		if ($sql->rowCount() > 0) {
			return $sql->fetchAll();
		}
		 return false;
	}



	public static function importStudentToNewDB($student) {
		$database = DatabaseFactory::getFactory()->getConnection();
		$query = $database->prepare("SELECT * FROM naatikdb.student WHERE id_student = :student;");
		$query->execute(array(':student' => $student));
		$student = array();
		if ($query->rowCount() > 0) {
			$alumno = $query->fetch();
			$students[$alumno->id_student] = new stdClass();
			$students[$alumno->id_student]->count        = $count++;
			$students[$alumno->id_student]->name         = ucwords(strtolower($alumno->name_s));
			$students[$alumno->id_student]->surname      = ucwords(strtolower($alumno->surname1_s));
			$students[$alumno->id_student]->lastname     = ucwords(strtolower($alumno->surname2_s));
			$students[$alumno->id_student]->birthdate    = $alumno->birthday;
			$students[$alumno->id_student]->age          = $alumno->age;
			$students[$alumno->id_student]->genre        = $alumno->sexo;
			$students[$alumno->id_student]->civil_status = $alumno->edo_civil;
			$students[$alumno->id_student]->cellphone    = $alumno->cellphone;
			$students[$alumno->id_student]->reference    = $alumno->reference;
			$students[$alumno->id_student]->isckness     = $alumno->sickness;
			$students[$alumno->id_student]->medication   = $alumno->medication;
			$students[$alumno->id_student]->avatar       = $alumno->photo_s;
			$students[$alumno->id_student]->description  = $alumno->comment_s;
			$students[$alumno->id_student]->homestay     = $alumno->homestay;
			$students[$alumno->id_student]->status       = $alumno->status;
			$students[$alumno->id_student]->tutor        = self::getTutor($alumno->id_tutor);
			$students[$alumno->id_student]->ubication    = self::getUbicationAddress($alumno->id_tutor);
			$students[$alumno->id_student]->academic_data = self::getAcademicInfo($alumno->id_student);
			$students[$alumno->id_student]->details       = self::getExtraInfo($alumno->id_student);
			$students[$alumno->id_student]->pay_data      = self::getPayHistoric($alumno->id_student);
			$students[$alumno->id_student]->scholar_data  = self::getBecasHistoric($alumno->id_student);
		}
		return $student;
	}

	public static function importPays() {
		$database = DatabaseFactory::getFactory()->getConnection();

	}

}
