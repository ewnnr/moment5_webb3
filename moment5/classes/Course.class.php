<?php
class Course {
    //properties
    private $db;
    private $code;
    private $name;
    private $progression;
    private $coursesyllabus;

    public function __construct(){
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

        if($this->db->connect_error){
        die("connection failed:" . $this->db->connect_error);
        }
    }

    /**
    *Lägg till kurs
    * @param string $code
    * @param string $name
    * @param string $progression
    * @param string $coursesyllabus
    * @return boolean
    */
    public function addCourse(string $code, string $name, string $progression, string $coursesyllabus): bool{
        $this->code=$code;
        $this->name=$name;
        $this->progression=$progression;
        $this->coursesyllabus=$coursesyllabus;

        //Prepare statement 
        $stmt = $this->db->prepare("INSERT INTO courses (code, name, progression, coursesyllabus) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $this->code, $this->name, $this->progression, $this->coursesyllabus);

        //Execute statement
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

        //Close statement
        $stmt->close();
    }

    /**
     * *Hämta alla kurser
     * @return array
     */
    public function getCourses() : array {
        $sql ="SELECT * FROM courses";
        $result = $this->db->query($sql);

        //Skicka tillbaka array
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * *Radera kurs
     * @param int id
     * @return boolean
     *  */
    public function deleteCourse(int $id) : bool{
        $id=intval($id);

        $sql= "DELETE FROM courses WHERE id=$id;";
        $result = $this->db->query($sql);

        return $result;

    }

    /**
     * *Hämta enskild kurs med id
     * @param int id
     * @return array
     */
    public function getCourseById(int $id):array{
        $id=intval($id);
        $sql = "SELECT * FROM courses WHERE id=$id;";
        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * *Uppdatera kurs
     * @param int id
     *  @param string $code
     * @param string $name
     * @param string $progression
     * @param string $coursesyllabus
     * @return boolean
     */
    public function updateCourse(int $id, string $code, string $name, string $progression, string $coursesyllabus):bool{
        $this->code=$code;
        $this->name=$name;
        $this->progression=$progression;
        $this->coursesyllabus=$coursesyllabus; 
        $id=intval($id);


        $stmt = $this->db->prepare("UPDATE courses SET code=?, name=?, progression=?, coursesyllabus=? WHERE id=$id;");
        $stmt->bind_param("ssss", $this->code, $this->name, $this->progression, $this->coursesyllabus);

        //Execute statement
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    
        //Close statement
        $stmt->close();
    }
 
}