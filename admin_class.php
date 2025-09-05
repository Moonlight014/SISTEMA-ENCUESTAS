<?php
session_start();
ini_set('display_errors', 1);
Class Action {
    private $db;

    public function __construct() {
        ob_start();
        include 'db_connect.php';

        $this->db = $conn;
    }
    function __destruct() {
        $this->db->close();
        ob_end_flush();
    }

    function login(){
        extract($_POST);
        $qry = $this->db->query("SELECT *, concat(nombres,' ',apellidos) as name FROM usuarios where email = '".$email."' and clave = '".md5($password)."' ");
        if($qry->num_rows > 0){
            foreach ($qry->fetch_array() as $key => $value) {
                if($key != 'clave' && !is_numeric($key))
                    $_SESSION['login_'.$key] = $value;
            }
            return 1;
        }else{
            return 3;
        }
    }
    function logout(){
        session_destroy();
        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }
        header("location:login.php");
    }

    // Guardar usuario
    function save_user(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k => $v){
            if(!in_array($k, array('id','cpass')) && !is_numeric($k)){
                if($k =='password')
                    $v = md5($v);
                if(empty($data)){
                    $data .= " $k='$v' ";
                }else{
                    $data .= ", $k='$v' ";
                }
            }
        }
        $check = $this->db->query("SELECT * FROM usuarios where email ='$email' ".(!empty($id) ? " and id_usuario != {$id} " : ''))->num_rows;
        if($check > 0){
            return 2;
            exit;
        }
        if(empty($id)){
            $save = $this->db->query("INSERT INTO usuarios set $data");
        }else{
            $save = $this->db->query("UPDATE usuarios set $data where id_usuario = $id");
        }

        if($save){
            return json_encode(array('status' => 1, 'message' => 'Usuario guardado correctamente.'));
        } else {
            return json_encode(array('status' => 2, 'message' => 'Error al guardar el usuario.'));
        }
    }

    // Guardar encuesta
    function save_survey(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k => $v){
            if(!in_array($k, array('id')) && !is_numeric($k)){
                if(empty($data)){
                    $data .= " $k='$v' ";
                }else{
                    $data .= ", $k='$v' ";
                }
            }
        }
        if(empty($id)){
            $save = $this->db->query("INSERT INTO encuestas set $data");
            if($save)
                return json_encode(array('status' => 1, 'message' => 'Encuesta guardada correctamente.'));
        }else{
            $save = $this->db->query("UPDATE encuestas set $data where id_encuesta = $id");
            if ($save)
                return json_encode(array('status' => 1, 'message' => 'Encuesta actualizada correctamente.'));
        }
        return json_encode(array('status' => 2, 'message' => 'Error al guardar la encuesta.'));
    }

    // Eliminar encuesta
    function delete_survey(){
        extract($_POST);
        $delete = $this->db->query("DELETE FROM encuestas where id_encuesta = ".$id);
        if($delete){
            return json_encode(array('status' => 1, 'message' => 'Encuesta eliminada correctamente.'));
        } else {
            return json_encode(array('status' => 2, 'message' => 'Error al eliminar la encuesta.'));
        }
    }

    // Guardar pregunta
    function save_question(){
        extract($_POST);
        $data = " id_encuesta=$sid ";
        $data .= ", titulo='$question' ";
        $data .= ", id_tipo_pregunta='$type' ";
        if(in_array($type, [1,3]) && isset($limit) && $limit > 0){
            $data .= ", limite_opciones='$limit' ";
        } else {
            $data .= ", limite_opciones=NULL ";
        }

        if(empty($id)){
            $save = $this->db->query("INSERT INTO preguntas set $data");
            if ($save)
                return json_encode(array('status' => 1, 'message' => 'Pregunta guardada correctamente.'));
        }else{
            $save = $this->db->query("UPDATE preguntas set $data where id_pregunta = $id");
            if ($save)
                return json_encode(array('status' => 1, 'message' => 'Pregunta actualizada correctamente.'));
        }
        return json_encode(array('status' => 2, 'message' => 'Error al guardar la pregunta.'));
    }

    // Eliminar pregunta
    function delete_question(){
        extract($_POST);
        $delete = $this->db->query("DELETE FROM preguntas where id_pregunta = ".$id);
        if($delete){
            return json_encode(array('status' => 1, 'message' => 'Pregunta eliminada correctamente.'));
        } else {
            return json_encode(array('status' => 2, 'message' => 'Error al eliminar la pregunta.'));
        }
    }

    // Guardar opción
    function save_option(){
        extract($_POST);
        $data = " id_pregunta=$qid ";
        $data .= ", valor='$option' ";

        if(empty($id)){
            $save = $this->db->query("INSERT INTO opciones set $data");
            if ($save)
                return json_encode(array('status' => 1, 'message' => 'Opción guardada correctamente.'));
        }else{
            $save = $this->db->query("UPDATE opciones set $data where id_opcion = $id");
            if ($save)
                return json_encode(array('status' => 1, 'message' => 'Opción actualizada correctamente.'));
        }
        return json_encode(array('status' => 2, 'message' => 'Error al guardar la opción.'));
    }

    // Eliminar opción
    function delete_option(){
        extract($_POST);
        $delete = $this->db->query("DELETE FROM opciones where id_opcion = ".$id);
        if($delete){
            return json_encode(array('status' => 1, 'message' => 'Opción eliminada correctamente.'));
        } else {
            return json_encode(array('status' => 2, 'message' => 'Error al eliminar la opción.'));
        }
    }

    // Actualizar estado de encuesta
    function update_survey_status(){
        extract($_POST);
        $save = $this->db->query("UPDATE encuestas set estado = $status where id_encuesta = $id");
        if($save){
            return json_encode(array('status' => 1, 'message' => 'Estado de encuesta actualizado correctamente.'));
        } else {
            return json_encode(array('status' => 2, 'message' => 'Error al actualizar el estado.'));
        }
    }

    // Obtener detalles de encuesta para edición
    function get_survey_details(){
        extract($_POST);
        $qry = $this->db->query("SELECT * FROM encuestas where id_encuesta = $id");
        if($qry->num_rows > 0){
            $data = $qry->fetch_assoc();
            return json_encode(array('status' => 1, 'data' => $data));
        } else {
            return json_encode(array('status' => 2, 'message' => 'Encuesta no encontrada.'));
        }
    }
}
