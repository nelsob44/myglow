<?php
class Topic {
    private $user_obj;
    private $con;

    public function __construct($con, $user) {
        $this->con = $con;
        $this->user_obj = new User($con, $user);
    }

    public function submitTopicPolitics($title, $post, $imagePath) {

        $title = strip_tags($_POST['forum_title']);
        $title = mysqli_real_escape_string($this->con, $title);

        $post = strip_tags($_POST['forum_post']);
        $post = mysqli_real_escape_string($this->con, $post);

        $check_empty = preg_replace('/\s+/', '', $post); //delete all spaces

        if($check_empty != "") {

            $body_array = preg_split("/\s+/", $post);

            foreach($body_array as $key => $value) {

                if(strpos($value, "www.youtube.com/watch?v=") !== false) {

                    $link = preg_split("!&!", $value);
                    $value = preg_replace("!watch\?v=!", "embed/", $link[0]);
                    $value = "<br><iframe width=\'420\' height=\'315\' src=\'".$value."\'></iframe><br>";

                    $body_array[$key] = $value;
                }
            }

            $post = implode(" ", $body_array);

            //current date and time
            $date_added = date("Y-m-d H:i:s");
            //get username
            $added_by = $this->user_obj->getUsername();


            $query = mysqli_query($this->con, "INSERT INTO forum_topics VALUES('', 'politics', '$added_by', '$title', '$post', '$imagePath', '$date_added', '0')");
            $returned_id = mysqli_insert_id($this->con);

            //Update post count for user
            $num_posts = $this->user_obj->getNumPosts();
            $num_posts++;
            $update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");

            $stopWords = "a about above across after again against all almost alone along already
      			 also although always among am an and another any anybody anyone anything anywhere are
      			 area areas around as ask asked asking asks at away b back backed backing backs be became
      			 because become becomes been before began behind being beings best better between big
      			 both but by c came can cannot case cases certain certainly clear clearly come could
      			 d did differ different differently do does done down down downed downing downs during
      			 e each early either end ended ending ends enough even evenly ever every everybody
      			 everyone everything everywhere f face faces fact facts far felt few find finds first
      			 for four from full fully further furthered furthering furthers g gave general generally
      			 get gets give given gives go going good goods got great greater greatest group grouped
      			 grouping groups h had has have having he her here herself high high high higher
      		     highest him himself his how however i im if important in interest interested interesting
      			 interests into is it its itself j just k keep keeps kind knew know known knows
      			 large largely last later latest least less let lets like likely long longer
      			 longest m made make making man many may me member members men might more most
      			 mostly mr mrs much must my myself n necessary need needed needing needs never
      			 new new newer newest next no nobody non noone not nothing now nowhere number
      			 numbers o of off often old older oldest on once one only open opened opening
      			 opens or order ordered ordering orders other others our out over p part parted
      			 parting parts people per person persons perhaps place places point pointed pointing points possible post
      			 present presented presenting presents print problem problems put puts q quite r
      			 rather really right right room rooms s said same saw say says second seconds
      			 see seem seemed seeming seems sees several shall she should show showed
      			 showing shows side sides since small smaller smallest so some somebody
      			 someone something somewhere state states still still such sure t take
      			 taken than that the their them then there therefore these they thing
      			 things think thinks this those though thought thoughts three through
      	         thus to today together too took toward turn turned turning turns two
      			 u under until up upon us use used uses v very w want wanted wanting
      			 wants was way ways we well wells went were what when where whether
      			 which while who whole whose why will with within without work
      			 worked working works would x y year years yet you young younger
      			 youngest your yours z lol haha omg hey ill iframe wonder else like
                   hate sleepy reason for some little yes bye choose  1 2 3 4 5 6 7 8 9 0";

            $stopWords = preg_split("/[\s,]+/", $stopWords);
            $no_punctuation = preg_replace("/[^a-zA-Z 0-9]+/", "", $post);

            if(strpos($no_punctuation, "height") === false && strpos($no_punctuation, "width") === false && strpos($no_punctuation, "http") === false) {
                $no_punctuation = preg_split("/[\s]+/", $no_punctuation);

                foreach($stopWords as $value) {
                    foreach($no_punctuation as $key => $value2) {
                        if(strtolower($value) == strtolower($value2))
                            $no_punctuation[$key] = "";
                    }
                }
                foreach($no_punctuation as $value) {
                    $this->calculateTrend(ucfirst($value));
                }
            }
        }
    }

    public function submitTopicCareers($title, $post, $imagePath) {

        $title = strip_tags($_POST['forum_title']);
        $title = mysqli_real_escape_string($this->con, $title);

        $post = strip_tags($_POST['forum_post']);
        $post = mysqli_real_escape_string($this->con, $post);

        $check_empty = preg_replace('/\s+/', '', $post); //delete all spaces

        if($check_empty != "") {

            $body_array = preg_split("/\s+/", $post);

            foreach($body_array as $key => $value) {

                if(strpos($value, "www.youtube.com/watch?v=") !== false) {

                    $link = preg_split("!&!", $value);
                    $value = preg_replace("!watch\?v=!", "embed/", $link[0]);
                    $value = "<br><iframe width=\'420\' height=\'315\' src=\'".$value."\'></iframe><br>";

                    $body_array[$key] = $value;
                }
            }

            $post = implode(" ", $body_array);

            //current date and time
            $date_added = date("Y-m-d H:i:s");
            //get username
            $added_by = $this->user_obj->getUsername();


            $query = mysqli_query($this->con, "INSERT INTO forum_topics VALUES('', 'careers', '$added_by', '$title', '$post', '$imagePath', '$date_added', '0')");
            $returned_id = mysqli_insert_id($this->con);

            //Update post count for user
            $num_posts = $this->user_obj->getNumPosts();
            $num_posts++;
            $update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");

            $stopWords = "a about above across after again against all almost alone along already
      			 also although always among am an and another any anybody anyone anything anywhere are
      			 area areas around as ask asked asking asks at away b back backed backing backs be became
      			 because become becomes been before began behind being beings best better between big
      			 both but by c came can cannot case cases certain certainly clear clearly come could
      			 d did differ different differently do does done down down downed downing downs during
      			 e each early either end ended ending ends enough even evenly ever every everybody
      			 everyone everything everywhere f face faces fact facts far felt few find finds first
      			 for four from full fully further furthered furthering furthers g gave general generally
      			 get gets give given gives go going good goods got great greater greatest group grouped
      			 grouping groups h had has have having he her here herself high high high higher
      		     highest him himself his how however i im if important in interest interested interesting
      			 interests into is it its itself j just k keep keeps kind knew know known knows
      			 large largely last later latest least less let lets like likely long longer
      			 longest m made make making man many may me member members men might more most
      			 mostly mr mrs much must my myself n necessary need needed needing needs never
      			 new new newer newest next no nobody non noone not nothing now nowhere number
      			 numbers o of off often old older oldest on once one only open opened opening
      			 opens or order ordered ordering orders other others our out over p part parted
      			 parting parts people per person persons perhaps place places point pointed pointing points possible post
      			 present presented presenting presents print problem problems put puts q quite r
      			 rather really right right room rooms s said same saw say says second seconds
      			 see seem seemed seeming seems sees several shall she should show showed
      			 showing shows side sides since small smaller smallest so some somebody
      			 someone something somewhere state states still still such sure t take
      			 taken than that the their them then there therefore these they thing
      			 things think thinks this those though thought thoughts three through
      	         thus to today together too took toward turn turned turning turns two
      			 u under until up upon us use used uses v very w want wanted wanting
      			 wants was way ways we well wells went were what when where whether
      			 which while who whole whose why will with within without work
      			 worked working works would x y year years yet you young younger
      			 youngest your yours z lol haha omg hey ill iframe wonder else like
                   hate sleepy reason for some little yes bye choose  1 2 3 4 5 6 7 8 9 0";

            $stopWords = preg_split("/[\s,]+/", $stopWords);
            $no_punctuation = preg_replace("/[^a-zA-Z 0-9]+/", "", $post);

            if(strpos($no_punctuation, "height") === false && strpos($no_punctuation, "width") === false && strpos($no_punctuation, "http") === false) {
                $no_punctuation = preg_split("/[\s]+/", $no_punctuation);

                foreach($stopWords as $value) {
                    foreach($no_punctuation as $key => $value2) {
                        if(strtolower($value) == strtolower($value2))
                            $no_punctuation[$key] = "";
                    }
                }
                foreach($no_punctuation as $value) {
                    $this->calculateTrend(ucfirst($value));
                }
            }
        }
    }


    public function submitTopicBusiness($title, $post, $imagePath) {

        $title = strip_tags($_POST['forum_title']);
        $title = mysqli_real_escape_string($this->con, $title);

        $post = strip_tags($_POST['forum_post']);
        $post = mysqli_real_escape_string($this->con, $post);

        $check_empty = preg_replace('/\s+/', '', $post); //delete all spaces

        if($check_empty != "") {

            $body_array = preg_split("/\s+/", $post);

            foreach($body_array as $key => $value) {

                if(strpos($value, "www.youtube.com/watch?v=") !== false) {

                    $link = preg_split("!&!", $value);
                    $value = preg_replace("!watch\?v=!", "embed/", $link[0]);
                    $value = "<br><iframe width=\'420\' height=\'315\' src=\'".$value."\'></iframe><br>";

                    $body_array[$key] = $value;
                }
            }

            $post = implode(" ", $body_array);

            //current date and time
            $date_added = date("Y-m-d H:i:s");
            //get username
            $added_by = $this->user_obj->getUsername();


            $query = mysqli_query($this->con, "INSERT INTO forum_topics VALUES('', 'business', '$added_by', '$title', '$post', '$imagePath', '$date_added', '0')");
            $returned_id = mysqli_insert_id($this->con);

            //Update post count for user
            $num_posts = $this->user_obj->getNumPosts();
            $num_posts++;
            $update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");

            $stopWords = "a about above across after again against all almost alone along already
      			 also although always among am an and another any anybody anyone anything anywhere are
      			 area areas around as ask asked asking asks at away b back backed backing backs be became
      			 because become becomes been before began behind being beings best better between big
      			 both but by c came can cannot case cases certain certainly clear clearly come could
      			 d did differ different differently do does done down down downed downing downs during
      			 e each early either end ended ending ends enough even evenly ever every everybody
      			 everyone everything everywhere f face faces fact facts far felt few find finds first
      			 for four from full fully further furthered furthering furthers g gave general generally
      			 get gets give given gives go going good goods got great greater greatest group grouped
      			 grouping groups h had has have having he her here herself high high high higher
      		     highest him himself his how however i im if important in interest interested interesting
      			 interests into is it its itself j just k keep keeps kind knew know known knows
      			 large largely last later latest least less let lets like likely long longer
      			 longest m made make making man many may me member members men might more most
      			 mostly mr mrs much must my myself n necessary need needed needing needs never
      			 new new newer newest next no nobody non noone not nothing now nowhere number
      			 numbers o of off often old older oldest on once one only open opened opening
      			 opens or order ordered ordering orders other others our out over p part parted
      			 parting parts people per person persons perhaps place places point pointed pointing points politics politicians possible post
      			 present presented presenting presents print problem problems put puts q quite r
      			 rather really right right room rooms s said same saw say says second seconds
      			 see seem seemed seeming seems sees several shall she should show showed
      			 showing shows side sides since small smaller smallest so some somebody
      			 someone something somewhere state states still still such sure t take
      			 taken than that the their them then there therefore these they thing
      			 things think thinks this those though thought thoughts three through
      	         thus to today together too took toward turn turned turning turns two
      			 u under until up upon us use used uses v very w want wanted wanting
      			 wants was way ways we well wells went were what when where whether
      			 which while who whole whose why will with within without work
      			 worked working works would x y year years yet you young younger
      			 youngest your yours z lol haha omg hey ill iframe wonder else like
                   hate sleepy reason for some little yes bye choose  1 2 3 4 5 6 7 8 9 0";

            $stopWords = preg_split("/[\s,]+/", $stopWords);
            $no_punctuation = preg_replace("/[^a-zA-Z 0-9]+/", "", $post);

            if(strpos($no_punctuation, "height") === false && strpos($no_punctuation, "width") === false && strpos($no_punctuation, "http") === false) {
                $no_punctuation = preg_split("/[\s]+/", $no_punctuation);

                foreach($stopWords as $value) {
                    foreach($no_punctuation as $key => $value2) {
                        if(strtolower($value) == strtolower($value2))
                            $no_punctuation[$key] = "";
                    }
                }
                foreach($no_punctuation as $value) {
                    $this->calculateTrend(ucfirst($value));
                }
            }
        }
    }

    public function submitTopicInternational($title, $post, $imagePath) {

        $title = strip_tags($_POST['forum_title']);
        $title = mysqli_real_escape_string($this->con, $title);

        $post = strip_tags($_POST['forum_post']);
        $post = mysqli_real_escape_string($this->con, $post);

        $check_empty = preg_replace('/\s+/', '', $post); //delete all spaces

        if($check_empty != "") {

            $body_array = preg_split("/\s+/", $post);

            foreach($body_array as $key => $value) {

                if(strpos($value, "www.youtube.com/watch?v=") !== false) {

                    $link = preg_split("!&!", $value);
                    $value = preg_replace("!watch\?v=!", "embed/", $link[0]);
                    $value = "<br><iframe width=\'420\' height=\'315\' src=\'".$value."\'></iframe><br>";

                    $body_array[$key] = $value;
                }
            }

            $post = implode(" ", $body_array);

            //current date and time
            $date_added = date("Y-m-d H:i:s");
            //get username
            $added_by = $this->user_obj->getUsername();


            $query = mysqli_query($this->con, "INSERT INTO forum_topics VALUES('', 'international', '$added_by', '$title', '$post', '$imagePath', '$date_added', '0')");
            $returned_id = mysqli_insert_id($this->con);

            //Update post count for user
            $num_posts = $this->user_obj->getNumPosts();
            $num_posts++;
            $update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");

            $stopWords = "a about above across after again against all almost alone along already
      			 also although always among am an and another any anybody anyone anything anywhere are
      			 area areas around as ask asked asking asks at away b back backed backing backs be became
      			 because become becomes been before began behind being beings best better between big
      			 both but by c came can cannot case cases certain certainly clear clearly come could
      			 d did differ different differently do does done down down downed downing downs during
      			 e each early either end ended ending ends enough even evenly ever every everybody
      			 everyone everything everywhere f face faces fact facts far felt few find finds first
      			 for four from full fully further furthered furthering furthers g gave general generally
      			 get gets give given gives go going good goods got great greater greatest group grouped
      			 grouping groups h had has have having he her here herself high high high higher
      		     highest him himself his how however i im if important in interest interested interesting
      			 interests into is it its itself j just k keep keeps kind knew know known knows
      			 large largely last later latest least less let lets like likely long longer
      			 longest m made make making man many may me member members men might more most
      			 mostly mr mrs much must my myself n necessary need needed needing needs never
      			 new new newer newest next no nobody non noone not nothing now nowhere number
      			 numbers o of off often old older oldest on once one only open opened opening
      			 opens or order ordered ordering orders other others our out over p part parted
      			 parting parts people per person persons perhaps place places point pointed pointing points possible post
      			 present presented presenting presents print problem problems put puts q quite r
      			 rather really right right room rooms s said same saw say says second seconds
      			 see seem seemed seeming seems sees several shall she should show showed
      			 showing shows side sides since small smaller smallest so some somebody
      			 someone something somewhere state states still still such sure t take
      			 taken than that the their them then there therefore these they thing
      			 things think thinks this those though thought thoughts three through
      	         thus to today together too took toward turn turned turning turns two
      			 u under until up upon us use used uses v very w want wanted wanting
      			 wants was way ways we well wells went were what when where whether
      			 which while who whole whose why will with within without work
      			 worked working works would x y year years yet you young younger
      			 youngest your yours z lol haha omg hey ill iframe wonder else like
                   hate sleepy reason for some little yes bye choose  1 2 3 4 5 6 7 8 9 0";

            $stopWords = preg_split("/[\s,]+/", $stopWords);
            $no_punctuation = preg_replace("/[^a-zA-Z 0-9]+/", "", $post);

            if(strpos($no_punctuation, "height") === false && strpos($no_punctuation, "width") === false && strpos($no_punctuation, "http") === false) {
                $no_punctuation = preg_split("/[\s]+/", $no_punctuation);

                foreach($stopWords as $value) {
                    foreach($no_punctuation as $key => $value2) {
                        if(strtolower($value) == strtolower($value2))
                            $no_punctuation[$key] = "";
                    }
                }
                foreach($no_punctuation as $value) {
                    $this->calculateTrend(ucfirst($value));
                }
            }
        }
    }


    public function submitTopicReligion($title, $post, $imagePath) {

        $title = strip_tags($_POST['forum_title']);
        $title = mysqli_real_escape_string($this->con, $title);

        $post = strip_tags($_POST['forum_post']);
        $post = mysqli_real_escape_string($this->con, $post);

        $check_empty = preg_replace('/\s+/', '', $post); //delete all spaces

        if($check_empty != "") {

            $body_array = preg_split("/\s+/", $post);

            foreach($body_array as $key => $value) {

                if(strpos($value, "www.youtube.com/watch?v=") !== false) {

                    $link = preg_split("!&!", $value);
                    $value = preg_replace("!watch\?v=!", "embed/", $link[0]);
                    $value = "<br><iframe width=\'420\' height=\'315\' src=\'".$value."\'></iframe><br>";

                    $body_array[$key] = $value;
                }
            }

            $post = implode(" ", $body_array);

            //current date and time
            $date_added = date("Y-m-d H:i:s");
            //get username
            $added_by = $this->user_obj->getUsername();


            $query = mysqli_query($this->con, "INSERT INTO forum_topics VALUES('', 'religion', '$added_by', '$title', '$post', '$imagePath', '$date_added', '0')");
            $returned_id = mysqli_insert_id($this->con);

            //Update post count for user
            $num_posts = $this->user_obj->getNumPosts();
            $num_posts++;
            $update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");

            $stopWords = "a about above across after again against all almost alone along already
      			 also although always among am an and another any anybody anyone anything anywhere are
      			 area areas around as ask asked asking asks at away b back backed backing backs be became
      			 because become becomes been before began behind being beings best better between big
      			 both but by c came can cannot case cases certain certainly clear clearly come could
      			 d did differ different differently do does done down down downed downing downs during
      			 e each early either end ended ending ends enough even evenly ever every everybody
      			 everyone everything everywhere f face faces fact facts far felt few find finds first
      			 for four from full fully further furthered furthering furthers g gave general generally
      			 get gets give given gives go going good goods got great greater greatest group grouped
      			 grouping groups h had has have having he her here herself high high high higher
      		     highest him himself his how however i im if important in interest interested interesting
      			 interests into is it its itself j just k keep keeps kind knew know known knows
      			 large largely last later latest least less let lets like likely long longer
      			 longest m made make making man many may me member members men might more most
      			 mostly mr mrs much must my myself n necessary need needed needing needs never
      			 new new newer newest next no nobody non noone not nothing now nowhere number
      			 numbers o of off often old older oldest on once one only open opened opening
      			 opens or order ordered ordering orders other others our out over p part parted
      			 parting parts people per person persons perhaps place places point pointed pointing points possible post
      			 present presented presenting presents print problem problems put puts q quite r
      			 rather really right right room rooms s said same saw say says second seconds
      			 see seem seemed seeming seems sees several shall she should show showed
      			 showing shows side sides since small smaller smallest so some somebody
      			 someone something somewhere state states still still such sure t take
      			 taken than that the their them then there therefore these they thing
      			 things think thinks this those though thought thoughts three through
      	         thus to today together too took toward turn turned turning turns two
      			 u under until up upon us use used uses v very w want wanted wanting
      			 wants was way ways we well wells went were what when where whether
      			 which while who whole whose why will with within without work
      			 worked working works would x y year years yet you young younger
      			 youngest your yours z lol haha omg hey ill iframe wonder else like
                   hate sleepy reason for some little yes bye choose  1 2 3 4 5 6 7 8 9 0";

            $stopWords = preg_split("/[\s,]+/", $stopWords);
            $no_punctuation = preg_replace("/[^a-zA-Z 0-9]+/", "", $post);

            if(strpos($no_punctuation, "height") === false && strpos($no_punctuation, "width") === false && strpos($no_punctuation, "http") === false) {
                $no_punctuation = preg_split("/[\s]+/", $no_punctuation);

                foreach($stopWords as $value) {
                    foreach($no_punctuation as $key => $value2) {
                        if(strtolower($value) == strtolower($value2))
                            $no_punctuation[$key] = "";
                    }
                }
                foreach($no_punctuation as $value) {
                    $this->calculateTrend(ucfirst($value));
                }
            }
        }
    }

    public function submitTopicEntertainment($title, $post, $imagePath) {

        $title = strip_tags($_POST['forum_title']);
        $title = mysqli_real_escape_string($this->con, $title);

        $post = strip_tags($_POST['forum_post']);
        $post = mysqli_real_escape_string($this->con, $post);

        $check_empty = preg_replace('/\s+/', '', $post); //delete all spaces

        if($check_empty != "") {

            $body_array = preg_split("/\s+/", $post);

            foreach($body_array as $key => $value) {

                if(strpos($value, "www.youtube.com/watch?v=") !== false) {

                    $link = preg_split("!&!", $value);
                    $value = preg_replace("!watch\?v=!", "embed/", $link[0]);
                    $value = "<br><iframe width=\'420\' height=\'315\' src=\'".$value."\'></iframe><br>";

                    $body_array[$key] = $value;
                }
            }

            $post = implode(" ", $body_array);

            //current date and time
            $date_added = date("Y-m-d H:i:s");
            //get username
            $added_by = $this->user_obj->getUsername();


            $query = mysqli_query($this->con, "INSERT INTO forum_topics VALUES('', 'entertainment', '$added_by', '$title', '$post', '$imagePath', '$date_added', '0')");
            $returned_id = mysqli_insert_id($this->con);

            //Update post count for user
            $num_posts = $this->user_obj->getNumPosts();
            $num_posts++;
            $update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");

            $stopWords = "a about above across after again against all almost alone along already
             also although always among am an and another any anybody anyone anything anywhere are
             area areas around as ask asked asking asks at away b back backed backing backs be became
             because become becomes been before began behind being beings best better between big
             both but by c came can cannot case cases certain certainly clear clearly come could
             d did differ different differently do does done down down downed downing downs during
             e each early either end ended ending ends enough even evenly ever every everybody
             everyone everything everywhere f face faces fact facts far felt few find finds first
             for four from full fully further furthered furthering furthers g gave general generally
             get gets give given gives go going good goods got great greater greatest group grouped
             grouping groups h had has have having he her here herself high high high higher
               highest him himself his how however i im if important in interest interested interesting
             interests into is it its itself j just k keep keeps kind knew know known knows
             large largely last later latest least less let lets like likely long longer
             longest m made make making man many may me member members men might more most
             mostly mr mrs much must my myself n necessary need needed needing needs never
             new new newer newest next no nobody non noone not nothing now nowhere number
             numbers o of off often old older oldest on once one only open opened opening
             opens or order ordered ordering orders other others our out over p part parted
             parting parts people per person persons perhaps place places point pointed pointing points possible post
             present presented presenting presents print problem problems put puts q quite r
             rather really right right room rooms s said same saw say says second seconds
             see seem seemed seeming seems sees several shall she should show showed
             showing shows side sides since small smaller smallest so some somebody
             someone something somewhere state states still still such sure t take
             taken than that the their them then there therefore these they thing
             things think thinks this those though thought thoughts three through
                 thus to today together too took toward turn turned turning turns two
             u under until up upon us use used uses v very w want wanted wanting
             wants was way ways we well wells went were what when where whether
             which while who whole whose why will with within without work
             worked working works would x y year years yet you young younger
             youngest your yours z lol haha omg hey ill iframe wonder else like
                   hate sleepy reason for some little yes bye choose  1 2 3 4 5 6 7 8 9 0";

            $stopWords = preg_split("/[\s,]+/", $stopWords);
            $no_punctuation = preg_replace("/[^a-zA-Z 0-9]+/", "", $post);

            if(strpos($no_punctuation, "height") === false && strpos($no_punctuation, "width") === false && strpos($no_punctuation, "http") === false) {
                $no_punctuation = preg_split("/[\s]+/", $no_punctuation);

                foreach($stopWords as $value) {
                    foreach($no_punctuation as $key => $value2) {
                        if(strtolower($value) == strtolower($value2))
                            $no_punctuation[$key] = "";
                    }
                }
                foreach($no_punctuation as $value) {
                    $this->calculateTrend(ucfirst($value));
                }
            }
        }
    }

    public function submitTopicEducation($title, $post, $imagePath) {

        $title = strip_tags($_POST['forum_title']);
        $title = mysqli_real_escape_string($this->con, $title);

        $post = strip_tags($_POST['forum_post']);
        $post = mysqli_real_escape_string($this->con, $post);

        $check_empty = preg_replace('/\s+/', '', $post); //delete all spaces

        if($check_empty != "") {

            $body_array = preg_split("/\s+/", $post);

            foreach($body_array as $key => $value) {

                if(strpos($value, "www.youtube.com/watch?v=") !== false) {

                    $link = preg_split("!&!", $value);
                    $value = preg_replace("!watch\?v=!", "embed/", $link[0]);
                    $value = "<br><iframe width=\'420\' height=\'315\' src=\'".$value."\'></iframe><br>";

                    $body_array[$key] = $value;
                }
            }

            $post = implode(" ", $body_array);

            //current date and time
            $date_added = date("Y-m-d H:i:s");
            //get username
            $added_by = $this->user_obj->getUsername();


            $query = mysqli_query($this->con, "INSERT INTO forum_topics VALUES('', 'education', '$added_by', '$title', '$post', '$imagePath', '$date_added', '0')");
            $returned_id = mysqli_insert_id($this->con);

            //Update post count for user
            $num_posts = $this->user_obj->getNumPosts();
            $num_posts++;
            $update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");

            $stopWords = "a about above across after again against all almost alone along already
      			 also although always among am an and another any anybody anyone anything anywhere are
      			 area areas around as ask asked asking asks at away b back backed backing backs be became
      			 because become becomes been before began behind being beings best better between big
      			 both but by c came can cannot case cases certain certainly clear clearly come could
      			 d did differ different differently do does done down down downed downing downs during
      			 e each early either end ended ending ends enough even evenly ever every everybody
      			 everyone everything everywhere f face faces fact facts far felt few find finds first
      			 for four from full fully further furthered furthering furthers g gave general generally
      			 get gets give given gives go going good goods got great greater greatest group grouped
      			 grouping groups h had has have having he her here herself high high high higher
      		     highest him himself his how however i im if important in interest interested interesting
      			 interests into is it its itself j just k keep keeps kind knew know known knows
      			 large largely last later latest least less let lets like likely long longer
      			 longest m made make making man many may me member members men might more most
      			 mostly mr mrs much must my myself n necessary need needed needing needs never
      			 new new newer newest next no nobody non noone not nothing now nowhere number
      			 numbers o of off often old older oldest on once one only open opened opening
      			 opens or order ordered ordering orders other others our out over p part parted
      			 parting parts people per person persons perhaps place places point pointed pointing points possible post
      			 present presented presenting presents print problem problems put puts q quite r
      			 rather really right right room rooms s said same saw say says second seconds
      			 see seem seemed seeming seems sees several shall she should show showed
      			 showing shows side sides since small smaller smallest so some somebody
      			 someone something somewhere state states still still such sure t take
      			 taken than that the their them then there therefore these they thing
      			 things think thinks this those though thought thoughts three through
      	         thus to today together too took toward turn turned turning turns two
      			 u under until up upon us use used uses v very w want wanted wanting
      			 wants was way ways we well wells went were what when where whether
      			 which while who whole whose why will with within without work
      			 worked working works would x y year years yet you young younger
      			 youngest your yours z lol haha omg hey ill iframe wonder else like
                   hate sleepy reason for some little yes bye choose  1 2 3 4 5 6 7 8 9 0";

            $stopWords = preg_split("/[\s,]+/", $stopWords);
            $no_punctuation = preg_replace("/[^a-zA-Z 0-9]+/", "", $post);

            if(strpos($no_punctuation, "height") === false && strpos($no_punctuation, "width") === false && strpos($no_punctuation, "http") === false) {
                $no_punctuation = preg_split("/[\s]+/", $no_punctuation);

                foreach($stopWords as $value) {
                    foreach($no_punctuation as $key => $value2) {
                        if(strtolower($value) == strtolower($value2))
                            $no_punctuation[$key] = "";
                    }
                }
                foreach($no_punctuation as $value) {
                    $this->calculateTrend(ucfirst($value));
                }
            }
        }
    }

    public function submitTopicScienceAndTechnology($title, $post, $imagePath) {

        $title = strip_tags($_POST['forum_title']);
        $title = mysqli_real_escape_string($this->con, $title);

        $post = strip_tags($_POST['forum_post']);
        $post = mysqli_real_escape_string($this->con, $post);

        $check_empty = preg_replace('/\s+/', '', $post); //delete all spaces

        if($check_empty != "") {

            $body_array = preg_split("/\s+/", $post);

            foreach($body_array as $key => $value) {

                if(strpos($value, "www.youtube.com/watch?v=") !== false) {

                    $link = preg_split("!&!", $value);
                    $value = preg_replace("!watch\?v=!", "embed/", $link[0]);
                    $value = "<br><iframe width=\'420\' height=\'315\' src=\'".$value."\'></iframe><br>";

                    $body_array[$key] = $value;
                }
            }

            $post = implode(" ", $body_array);

            //current date and time
            $date_added = date("Y-m-d H:i:s");
            //get username
            $added_by = $this->user_obj->getUsername();


            $query = mysqli_query($this->con, "INSERT INTO forum_topics VALUES('', 'scienceandtechnology', '$added_by', '$title', '$post', '$imagePath', '$date_added', '0')");
            $returned_id = mysqli_insert_id($this->con);

            //Update post count for user
            $num_posts = $this->user_obj->getNumPosts();
            $num_posts++;
            $update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");

            $stopWords = "a about above across after again against all almost alone along already
      			 also although always among am an and another any anybody anyone anything anywhere are
      			 area areas around as ask asked asking asks at away b back backed backing backs be became
      			 because become becomes been before began behind being beings best better between big
      			 both but by c came can cannot case cases certain certainly clear clearly come could
      			 d did differ different differently do does done down down downed downing downs during
      			 e each early either end ended ending ends enough even evenly ever every everybody
      			 everyone everything everywhere f face faces fact facts far felt few find finds first
      			 for four from full fully further furthered furthering furthers g gave general generally
      			 get gets give given gives go going good goods got great greater greatest group grouped
      			 grouping groups h had has have having he her here herself high high high higher
      		     highest him himself his how however i im if important in interest interested interesting
      			 interests into is it its itself j just k keep keeps kind knew know known knows
      			 large largely last later latest least less let lets like likely long longer
      			 longest m made make making man many may me member members men might more most
      			 mostly mr mrs much must my myself n necessary need needed needing needs never
      			 new new newer newest next no nobody non noone not nothing now nowhere number
      			 numbers o of off often old older oldest on once one only open opened opening
      			 opens or order ordered ordering orders other others our out over p part parted
      			 parting parts people per person persons perhaps place places point pointed pointing points possible post
      			 present presented presenting presents print problem problems put puts q quite r
      			 rather really right right room rooms s said same saw say says second seconds
      			 see seem seemed seeming seems sees several shall she should show showed
      			 showing shows side sides since small smaller smallest so some somebody
      			 someone something somewhere state states still still such sure t take
      			 taken than that the their them then there therefore these they thing
      			 things think thinks this those though thought thoughts three through
      	         thus to today together too took toward turn turned turning turns two
      			 u under until up upon us use used uses v very w want wanted wanting
      			 wants was way ways we well wells went were what when where whether
      			 which while who whole whose why will with within without work
      			 worked working works would x y year years yet you young younger
      			 youngest your yours z lol haha omg hey ill iframe wonder else like
                   hate sleepy reason for some little yes bye choose  1 2 3 4 5 6 7 8 9 0";

            $stopWords = preg_split("/[\s,]+/", $stopWords);
            $no_punctuation = preg_replace("/[^a-zA-Z 0-9]+/", "", $post);

            if(strpos($no_punctuation, "height") === false && strpos($no_punctuation, "width") === false && strpos($no_punctuation, "http") === false) {
                $no_punctuation = preg_split("/[\s]+/", $no_punctuation);

                foreach($stopWords as $value) {
                    foreach($no_punctuation as $key => $value2) {
                        if(strtolower($value) == strtolower($value2))
                            $no_punctuation[$key] = "";
                    }
                }
                foreach($no_punctuation as $value) {
                    $this->calculateTrend(ucfirst($value));
                }
            }
        }
    }

    public function submitTopicArtsAndLiterature($title, $post, $imagePath) {

        $title = strip_tags($_POST['forum_title']);
        $title = mysqli_real_escape_string($this->con, $title);

        $post = strip_tags($_POST['forum_post']);
        $post = mysqli_real_escape_string($this->con, $post);

        $check_empty = preg_replace('/\s+/', '', $post); //delete all spaces

        if($check_empty != "") {

            $body_array = preg_split("/\s+/", $post);

            foreach($body_array as $key => $value) {

                if(strpos($value, "www.youtube.com/watch?v=") !== false) {

                    $link = preg_split("!&!", $value);
                    $value = preg_replace("!watch\?v=!", "embed/", $link[0]);
                    $value = "<br><iframe width=\'420\' height=\'315\' src=\'".$value."\'></iframe><br>";

                    $body_array[$key] = $value;
                }
            }

            $post = implode(" ", $body_array);

            //current date and time
            $date_added = date("Y-m-d H:i:s");
            //get username
            $added_by = $this->user_obj->getUsername();


            $query = mysqli_query($this->con, "INSERT INTO forum_topics VALUES('', 'artsandliterature', '$added_by', '$title', '$post', '$imagePath', '$date_added', '0')");
            $returned_id = mysqli_insert_id($this->con);

            //Update post count for user
            $num_posts = $this->user_obj->getNumPosts();
            $num_posts++;
            $update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");

            $stopWords = "a about above across after again against all almost alone along already
      			 also although always among am an and another any anybody anyone anything anywhere are
      			 area areas around as ask asked asking asks at away b back backed backing backs be became
      			 because become becomes been before began behind being beings best better between big
      			 both but by c came can cannot case cases certain certainly clear clearly come could
      			 d did differ different differently do does done down down downed downing downs during
      			 e each early either end ended ending ends enough even evenly ever every everybody
      			 everyone everything everywhere f face faces fact facts far felt few find finds first
      			 for four from full fully further furthered furthering furthers g gave general generally
      			 get gets give given gives go going good goods got great greater greatest group grouped
      			 grouping groups h had has have having he her here herself high high high higher
      		     highest him himself his how however i im if important in interest interested interesting
      			 interests into is it its itself j just k keep keeps kind knew know known knows
      			 large largely last later latest least less let lets like likely long longer
      			 longest m made make making man many may me member members men might more most
      			 mostly mr mrs much must my myself n necessary need needed needing needs never
      			 new new newer newest next no nobody non noone not nothing now nowhere number
      			 numbers o of off often old older oldest on once one only open opened opening
      			 opens or order ordered ordering orders other others our out over p part parted
      			 parting parts people per person persons perhaps place places point pointed pointing points possible post
      			 present presented presenting presents print problem problems put puts q quite r
      			 rather really right right room rooms s said same saw say says second seconds
      			 see seem seemed seeming seems sees several shall she should show showed
      			 showing shows side sides since small smaller smallest so some somebody
      			 someone something somewhere state states still still such sure t take
      			 taken than that the their them then there therefore these they thing
      			 things think thinks this those though thought thoughts three through
      	         thus to today together too took toward turn turned turning turns two
      			 u under until up upon us use used uses v very w want wanted wanting
      			 wants was way ways we well wells went were what when where whether
      			 which while who whole whose why will with within without work
      			 worked working works would x y year years yet you young younger
      			 youngest your yours z lol haha omg hey ill iframe wonder else like
                   hate sleepy reason for some little yes bye choose  1 2 3 4 5 6 7 8 9 0";

            $stopWords = preg_split("/[\s,]+/", $stopWords);
            $no_punctuation = preg_replace("/[^a-zA-Z 0-9]+/", "", $post);

            if(strpos($no_punctuation, "height") === false && strpos($no_punctuation, "width") === false && strpos($no_punctuation, "http") === false) {
                $no_punctuation = preg_split("/[\s]+/", $no_punctuation);

                foreach($stopWords as $value) {
                    foreach($no_punctuation as $key => $value2) {
                        if(strtolower($value) == strtolower($value2))
                            $no_punctuation[$key] = "";
                    }
                }
                foreach($no_punctuation as $value) {
                    $this->calculateTrend(ucfirst($value));
                }
            }
        }
    }

    public function submitTopicRomanceAndRelationships($title, $post, $imagePath) {

        $title = strip_tags($_POST['forum_title']);
        $title = mysqli_real_escape_string($this->con, $title);

        $post = strip_tags($_POST['forum_post']);
        $post = mysqli_real_escape_string($this->con, $post);

        $check_empty = preg_replace('/\s+/', '', $post); //delete all spaces

        if($check_empty != "") {

            $body_array = preg_split("/\s+/", $post);

            foreach($body_array as $key => $value) {

                if(strpos($value, "www.youtube.com/watch?v=") !== false) {

                    $link = preg_split("!&!", $value);
                    $value = preg_replace("!watch\?v=!", "embed/", $link[0]);
                    $value = "<br><iframe width=\'420\' height=\'315\' src=\'".$value."\'></iframe><br>";

                    $body_array[$key] = $value;
                }
            }

            $post = implode(" ", $body_array);

            //current date and time
            $date_added = date("Y-m-d H:i:s");
            //get username
            $added_by = $this->user_obj->getUsername();


            $query = mysqli_query($this->con, "INSERT INTO forum_topics VALUES('', 'romanceandrelationships', '$added_by', '$title', '$post', '$imagePath', '$date_added', '0')");
            $returned_id = mysqli_insert_id($this->con);

            //Update post count for user
            $num_posts = $this->user_obj->getNumPosts();
            $num_posts++;
            $update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");

            $stopWords = "a about above across after again against all almost alone along already
             also although always among am an and another any anybody anyone anything anywhere are
             area areas around as ask asked asking asks at away b back backed backing backs be became
             because become becomes been before began behind being beings best better between big
             both but by c came can cannot case cases certain certainly clear clearly come could
             d did differ different differently do does done down down downed downing downs during
             e each early either end ended ending ends enough even evenly ever every everybody
             everyone everything everywhere f face faces fact facts far felt few find finds first
             for four from full fully further furthered furthering furthers g gave general generally
             get gets give given gives go going good goods got great greater greatest group grouped
             grouping groups h had has have having he her here herself high high high higher
               highest him himself his how however i im if important in interest interested interesting
             interests into is it its itself j just k keep keeps kind knew know known knows
             large largely last later latest least less let lets like likely long longer
             longest m made make making man many may me member members men might more most
             mostly mr mrs much must my myself n necessary need needed needing needs never
             new new newer newest next no nobody non noone not nothing now nowhere number
             numbers o of off often old older oldest on once one only open opened opening
             opens or order ordered ordering orders other others our out over p part parted
             parting parts people per person persons perhaps place places point pointed pointing points possible post
             present presented presenting presents print problem problems put puts q quite r
             rather really right right room rooms s said same saw say says second seconds
             see seem seemed seeming seems sees several shall she should show showed
             showing shows side sides since small smaller smallest so some somebody
             someone something somewhere state states still still such sure t take
             taken than that the their them then there therefore these they thing
             things think thinks this those though thought thoughts three through
                 thus to today together too took toward turn turned turning turns two
             u under until up upon us use used uses v very w want wanted wanting
             wants was way ways we well wells went were what when where whether
             which while who whole whose why will with within without work
             worked working works would x y year years yet you young younger
             youngest your yours z lol haha omg hey ill iframe wonder else like
                   hate sleepy reason for some little yes bye choose  1 2 3 4 5 6 7 8 9 0";

            $stopWords = preg_split("/[\s,]+/", $stopWords);
            $no_punctuation = preg_replace("/[^a-zA-Z 0-9]+/", "", $post);

            if(strpos($no_punctuation, "height") === false && strpos($no_punctuation, "width") === false && strpos($no_punctuation, "http") === false) {
                $no_punctuation = preg_split("/[\s]+/", $no_punctuation);

                foreach($stopWords as $value) {
                    foreach($no_punctuation as $key => $value2) {
                        if(strtolower($value) == strtolower($value2))
                            $no_punctuation[$key] = "";
                    }
                }
                foreach($no_punctuation as $value) {
                    $this->calculateTrend(ucfirst($value));
                }
            }
        }
    }

    public function submitTopicJokes($title, $post, $imagePath) {

        $title = strip_tags($_POST['forum_title']);
        $title = mysqli_real_escape_string($this->con, $title);

        $post = strip_tags($_POST['forum_post']);
        $post = mysqli_real_escape_string($this->con, $post);

        $check_empty = preg_replace('/\s+/', '', $post); //delete all spaces

        if($check_empty != "") {

            $body_array = preg_split("/\s+/", $post);

            foreach($body_array as $key => $value) {

                if(strpos($value, "www.youtube.com/watch?v=") !== false) {

                    $link = preg_split("!&!", $value);
                    $value = preg_replace("!watch\?v=!", "embed/", $link[0]);
                    $value = "<br><iframe width=\'420\' height=\'315\' src=\'".$value."\'></iframe><br>";

                    $body_array[$key] = $value;
                }
            }

            $post = implode(" ", $body_array);

            //current date and time
            $date_added = date("Y-m-d H:i:s");
            //get username
            $added_by = $this->user_obj->getUsername();


            $query = mysqli_query($this->con, "INSERT INTO forum_topics VALUES('', 'jokes', '$added_by', '$title', '$post', '$imagePath', '$date_added', '0')");
            $returned_id = mysqli_insert_id($this->con);

            //Update post count for user
            $num_posts = $this->user_obj->getNumPosts();
            $num_posts++;
            $update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");

            $stopWords = "a about above across after again against all almost alone along already
      			 also although always among am an and another any anybody anyone anything anywhere are
      			 area areas around as ask asked asking asks at away b back backed backing backs be became
      			 because become becomes been before began behind being beings best better between big
      			 both but by c came can cannot case cases certain certainly clear clearly come could
      			 d did differ different differently do does done down down downed downing downs during
      			 e each early either end ended ending ends enough even evenly ever every everybody
      			 everyone everything everywhere f face faces fact facts far felt few find finds first
      			 for four from full fully further furthered furthering furthers g gave general generally
      			 get gets give given gives go going good goods got great greater greatest group grouped
      			 grouping groups h had has have having he her here herself high high high higher
      		     highest him himself his how however i im if important in interest interested interesting
      			 interests into is it its itself j just k keep keeps kind knew know known knows
      			 large largely last later latest least less let lets like likely long longer
      			 longest m made make making man many may me member members men might more most
      			 mostly mr mrs much must my myself n necessary need needed needing needs never
      			 new new newer newest next no nobody non noone not nothing now nowhere number
      			 numbers o of off often old older oldest on once one only open opened opening
      			 opens or order ordered ordering orders other others our out over p part parted
      			 parting parts people per person persons perhaps place places point pointed pointing points possible post
      			 present presented presenting presents print problem problems put puts q quite r
      			 rather really right right room rooms s said same saw say says second seconds
      			 see seem seemed seeming seems sees several shall she should show showed
      			 showing shows side sides since small smaller smallest so some somebody
      			 someone something somewhere state states still still such sure t take
      			 taken than that the their them then there therefore these they thing
      			 things think thinks this those though thought thoughts three through
      	         thus to today together too took toward turn turned turning turns two
      			 u under until up upon us use used uses v very w want wanted wanting
      			 wants was way ways we well wells went were what when where whether
      			 which while who whole whose why will with within without work
      			 worked working works would x y year years yet you young younger
      			 youngest your yours z lol haha omg hey ill iframe wonder else like
                   hate sleepy reason for some little yes bye choose  1 2 3 4 5 6 7 8 9 0";

            $stopWords = preg_split("/[\s,]+/", $stopWords);
            $no_punctuation = preg_replace("/[^a-zA-Z 0-9]+/", "", $post);

            if(strpos($no_punctuation, "height") === false && strpos($no_punctuation, "width") === false && strpos($no_punctuation, "http") === false) {
                $no_punctuation = preg_split("/[\s]+/", $no_punctuation);

                foreach($stopWords as $value) {
                    foreach($no_punctuation as $key => $value2) {
                        if(strtolower($value) == strtolower($value2))
                            $no_punctuation[$key] = "";
                    }
                }
                foreach($no_punctuation as $value) {
                    $this->calculateTrend(ucfirst($value));
                }
            }
        }
    }

    public function submitTopicSports($title, $post, $imagePath) {

        $title = strip_tags($_POST['forum_title']);
        $title = mysqli_real_escape_string($this->con, $title);

        $post = strip_tags($_POST['forum_post']);
        $post = mysqli_real_escape_string($this->con, $post);

        $check_empty = preg_replace('/\s+/', '', $post); //delete all spaces

        if($check_empty != "") {

            $body_array = preg_split("/\s+/", $post);

            foreach($body_array as $key => $value) {

                if(strpos($value, "www.youtube.com/watch?v=") !== false) {

                    $link = preg_split("!&!", $value);
                    $value = preg_replace("!watch\?v=!", "embed/", $link[0]);
                    $value = "<br><iframe width=\'420\' height=\'315\' src=\'".$value."\'></iframe><br>";

                    $body_array[$key] = $value;
                }
            }

            $post = implode(" ", $body_array);

            //current date and time
            $date_added = date("Y-m-d H:i:s");
            //get username
            $added_by = $this->user_obj->getUsername();


            $query = mysqli_query($this->con, "INSERT INTO forum_topics VALUES('', 'sports', '$added_by', '$title', '$post', '$imagePath', '$date_added', '0')");
            $returned_id = mysqli_insert_id($this->con);

            //Update post count for user
            $num_posts = $this->user_obj->getNumPosts();
            $num_posts++;
            $update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");

            $stopWords = "a about above across after again against all almost alone along already
             also although always among am an and another any anybody anyone anything anywhere are
             area areas around as ask asked asking asks at away b back backed backing backs be became
             because become becomes been before began behind being beings best better between big
             both but by c came can cannot case cases certain certainly clear clearly come could
             d did differ different differently do does done down down downed downing downs during
             e each early either end ended ending ends enough even evenly ever every everybody
             everyone everything everywhere f face faces fact facts far felt few find finds first
             for four from full fully further furthered furthering furthers g gave general generally
             get gets give given gives go going good goods got great greater greatest group grouped
             grouping groups h had has have having he her here herself high high high higher
               highest him himself his how however i im if important in interest interested interesting
             interests into is it its itself j just k keep keeps kind knew know known knows
             large largely last later latest least less let lets like likely long longer
             longest m made make making man many may me member members men might more most
             mostly mr mrs much must my myself n necessary need needed needing needs never
             new new newer newest next no nobody non noone not nothing now nowhere number
             numbers o of off often old older oldest on once one only open opened opening
             opens or order ordered ordering orders other others our out over p part parted
             parting parts people per person persons perhaps place places point pointed pointing points possible post
             present presented presenting presents print problem problems put puts q quite r
             rather really right right room rooms s said same saw say says second seconds
             see seem seemed seeming seems sees several shall she should show showed
             showing shows side sides since small smaller smallest so some somebody
             someone something somewhere state states still still such sure t take
             taken than that the their them then there therefore these they thing
             things think thinks this those though thought thoughts three through
                 thus to today together too took toward turn turned turning turns two
             u under until up upon us use used uses v very w want wanted wanting
             wants was way ways we well wells went were what when where whether
             which while who whole whose why will with within without work
             worked working works would x y year years yet you young younger
             youngest your yours z lol haha omg hey ill iframe wonder else like
                   hate sleepy reason for some little yes bye choose  1 2 3 4 5 6 7 8 9 0";

            $stopWords = preg_split("/[\s,]+/", $stopWords);
            $no_punctuation = preg_replace("/[^a-zA-Z 0-9]+/", "", $post);

            if(strpos($no_punctuation, "height") === false && strpos($no_punctuation, "width") === false && strpos($no_punctuation, "http") === false) {
                $no_punctuation = preg_split("/[\s]+/", $no_punctuation);

                foreach($stopWords as $value) {
                    foreach($no_punctuation as $key => $value2) {
                        if(strtolower($value) == strtolower($value2))
                            $no_punctuation[$key] = "";
                    }
                }
                foreach($no_punctuation as $value) {
                    $this->calculateTrend(ucfirst($value));
                }
            }
        }
    }

    public function submitTopicMarketPlace($title, $post, $imagePath) {

        $title = strip_tags($_POST['forum_title']);
        $title = mysqli_real_escape_string($this->con, $title);

        $post = strip_tags($_POST['forum_post']);
        $post = mysqli_real_escape_string($this->con, $post);

        $check_empty = preg_replace('/\s+/', '', $post); //delete all spaces

        if($check_empty != "") {

            $body_array = preg_split("/\s+/", $post);

            foreach($body_array as $key => $value) {

                if(strpos($value, "www.youtube.com/watch?v=") !== false) {

                    $link = preg_split("!&!", $value);
                    $value = preg_replace("!watch\?v=!", "embed/", $link[0]);
                    $value = "<br><iframe width=\'420\' height=\'315\' src=\'".$value."\'></iframe><br>";

                    $body_array[$key] = $value;
                }
            }

            $post = implode(" ", $body_array);

            //current date and time
            $date_added = date("Y-m-d H:i:s");
            //get username
            $added_by = $this->user_obj->getUsername();


            $query = mysqli_query($this->con, "INSERT INTO forum_topics VALUES('', 'marketplace', '$added_by', '$title', '$post', '$imagePath', '$date_added', '0')");
            $returned_id = mysqli_insert_id($this->con);

            //Update post count for user
            $num_posts = $this->user_obj->getNumPosts();
            $num_posts++;
            $update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");

            $stopWords = "a about above across after again against all almost alone along already
      			 also although always among am an and another any anybody anyone anything anywhere are
      			 area areas around as ask asked asking asks at away b back backed backing backs be became
      			 because become becomes been before began behind being beings best better between big
      			 both but by c came can cannot case cases certain certainly clear clearly come could
      			 d did differ different differently do does done down down downed downing downs during
      			 e each early either end ended ending ends enough even evenly ever every everybody
      			 everyone everything everywhere f face faces fact facts far felt few find finds first
      			 for four from full fully further furthered furthering furthers g gave general generally
      			 get gets give given gives go going good goods got great greater greatest group grouped
      			 grouping groups h had has have having he her here herself high high high higher
      		     highest him himself his how however i im if important in interest interested interesting
      			 interests into is it its itself j just k keep keeps kind knew know known knows
      			 large largely last later latest least less let lets like likely long longer
      			 longest m made make making man many may me member members men might more most
      			 mostly mr mrs much must my myself n necessary need needed needing needs never
      			 new new newer newest next no nobody non noone not nothing now nowhere number
      			 numbers o of off often old older oldest on once one only open opened opening
      			 opens or order ordered ordering orders other others our out over p part parted
      			 parting parts people per person persons perhaps place places point pointed pointing points possible post
      			 present presented presenting presents print problem problems put puts q quite r
      			 rather really right right room rooms s said same saw say says second seconds
      			 see seem seemed seeming seems sees several shall she should show showed
      			 showing shows side sides since small smaller smallest so some somebody
      			 someone something somewhere state states still still such sure t take
      			 taken than that the their them then there therefore these they thing
      			 things think thinks this those though thought thoughts three through
      	         thus to today together too took toward turn turned turning turns two
      			 u under until up upon us use used uses v very w want wanted wanting
      			 wants was way ways we well wells went were what when where whether
      			 which while who whole whose why will with within without work
      			 worked working works would x y year years yet you young younger
      			 youngest your yours z lol haha omg hey ill iframe wonder else like
                   hate sleepy reason for some little yes bye choose  1 2 3 4 5 6 7 8 9 0";

            $stopWords = preg_split("/[\s,]+/", $stopWords);
            $no_punctuation = preg_replace("/[^a-zA-Z 0-9]+/", "", $post);

            if(strpos($no_punctuation, "height") === false && strpos($no_punctuation, "width") === false && strpos($no_punctuation, "http") === false) {
                $no_punctuation = preg_split("/[\s]+/", $no_punctuation);

                foreach($stopWords as $value) {
                    foreach($no_punctuation as $key => $value2) {
                        if(strtolower($value) == strtolower($value2))
                            $no_punctuation[$key] = "";
                    }
                }
                foreach($no_punctuation as $value) {
                    $this->calculateTrend(ucfirst($value));
                }
            }
        }
    }


    public function calculateTrend($term) {
        if($term != '') {
            $query = mysqli_query($this->con, "SELECT * FROM trends WHERE title='$term'");

            if(mysqli_num_rows($query) == 0)
                $insert_query = mysqli_query($this->con, "INSERT INTO trends(title, hits) VALUES('$term', '1')");
            else
                $insert_query = mysqli_query($this->con, "UPDATE trends SET hits=hits+1 WHERE title='$term'");
        }
    }

    public function loadTopicPolitics() {

        $userLoggedIn = $this->user_obj->getUsername();
        define("admin", "abigail_oba");

        $str = " "; //string to return

        if(isset($_GET['page'])) {
          $page = $_GET['page'];
          if($page == 0 || $page<1 ) {
                $showPostFrom = 0;
            }else {
                $showPostFrom = ($page * 30) - 30;
            }

          $data_query = mysqli_query($this->con, "SELECT * FROM forum_topics WHERE category='politics' ORDER BY id DESC LIMIT $showPostFrom, 30");
          $count = mysqli_num_rows($data_query);
          $PostsPerPage = $count/30;
          $PostsPerPage = ceil($PostsPerPage);

            if(mysqli_num_rows($data_query) > 0) {

                $num_iterations = 0; //Number of results checked (not necessarily posted)
                $count = 1;

                while($row = mysqli_fetch_array($data_query)) {
                    $id = $row['id'];
                    $post = $row['post'];
                    $title = $row['title'];
                    $category = $row['category'];
                    $added_by = $row['posted_by'];
                    $date_time = $row['date_posted'];
                    $imagePath = $row['image_attachment'];
                    $likes = $row['likes'];


                        if($userLoggedIn == $added_by || $userLoggedIn == admin)
                            $delete_button = "<button class='delete_button btn-danger' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='forum_post$id'>x</button>";
                        else
                            $delete_button = "";

                        if($userLoggedIn == admin)
                            $move_button = "<button class='move_button btn-success' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='move_forum_post$id'>m</button>";
                        else
                            $move_button = "";

                        $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
                        $user_row = mysqli_fetch_array($user_details_query);
                        $first_name = $user_row['first_name'];
                        $last_name = $user_row['last_name'];
                        $profile_pic = $user_row['profile_pic'];

                        ?>
                        <script>
                            function toggle<?php echo $id; ?>() {

                                var target = $(event.target);
                                if(!target.is("a")) {

                                    var element = document.getElementById("toggleComment<?php echo $id; ?>");
                                    if(element.style.display == "block")
                                        element.style.display = "none";
                                    else
                                        element.style.display = "block";
                                    }
                                }


                        </script>


                        <?php

                        $comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE forum_post_id='$id'");
                        $comments_check_num = mysqli_num_rows($comments_check);

                        //Timeframe
                        $date_time_now = date("Y-m-d H:i:s");
                        $start_date = new DateTime($date_time); //Time of post
                        $end_date = new DateTime($date_time_now); //Current time
                        $interval = $start_date->diff($end_date); //Difference between dates
                        if($interval->y >= 1) {
                            if($interval == 1)
                                $time_message = $interval->y." year ago"; //1 year ago
                            else
                                $time_message = $interval->y." years ago"; //1 year ago

                        }
                        else if($interval->m >= 1) {
                            if($interval->d == 0) {
                                $days = " ago";
                            }
                            else if($interval->d == 1) {
                                $days = $interval->d . " day ago";
                            }
                            else {
                                $days = $interval->d . " days ago";
                            }

                            if($interval->m == 1) {
                                $time_message = $interval->m . " month".$days;
                            }
                            else {
                                $time_message = $interval->m . " months".$days;
                            }
                        }

                        else if($interval->d >= 1) {
                            if($interval->d == 1) {
                                $time_message = "Yesterday";
                            }
                            else {
                                $time_message = $interval->d . " days ago";
                            }
                        }
                        else if($interval->h >= 1) {
                            if($interval->h == 1) {
                                $time_message = $interval->h . " hour ago";
                            }
                            else {
                                $time_message = $interval->h . " hours ago";
                            }
                        }

                        else if($interval->i >= 1) {
                            if($interval->i == 1) {
                                $time_message = $interval->i . " minute ago";
                            }
                            else {
                                $time_message = $interval->i . " minutes ago";
                            }
                        }

                        else {
                            if($interval->s < 30) {
                                $time_message = "Just now";
                            }
                            else {
                                $time_message = $interval->s . " seconds ago";
                            }
                        }

                        if($imagePath != "") {
                            $imageDiv = "<div class='postedImage'>
                                            <img src='$imagePath'>
                                        </div>";
                        }
                        else {
                            $imageDiv = "";
                        }

                        $str .= "<div class='forum_post' style='color:#ACACAC; border: 1px #D3D3D3 solid; padding:10px; text-align:center;'>


                                        <img src='$profile_pic' style='width:30px; height:30px; border-radius:15px; margin-right:10px;'><a href='post_details.php?forum_post_id=$id&page=1'><b>&laquo; $title &raquo;</b></a>
                                        <br><small style='font-size:11px;'>Posted by: $added_by &nbsp; $time_message &nbsp;&nbsp; Comments($comments_check_num) &nbsp;$delete_button&nbsp;&nbsp;$move_button</small>


                                </div>";

                    ?>
                    <script type="text/javascript">
                        $(document).ready(function() {

                            $('#forum_post<?php echo $id; ?>').on('click', function(){
                                bootbox.confirm("Are you sure you want to delete this post?", function(result) {
                                    $.post("includes/form_handlers/delete_forum_post.php?forum_post_id=<?php echo $id; ?>",
                                        {result:result});
                                    if(result)
                                        location.reload();

                                });

                            });

                            $('#move_forum_post<?php echo $id; ?>').on('click', function(){
                                bootbox.confirm("Are you sure you want to move this post to front page?", function(result) {
                                    $.post("includes/form_handlers/move_forum_post.php?move_forum_post_id=<?php echo $id; ?>",
                                        {result:result});
                                    if(result)
                                        location.reload();

                                });

                            });

                        });



                    </script>



                    <?php
                    }
                  }

        }

        echo $str;
    }


    public function loadTopicCareers() {

      $userLoggedIn = $this->user_obj->getUsername();
        define("admin", "abigail_oba");

      $str = " "; //string to return

      if(isset($_GET['page'])) {
        $page = $_GET['page'];
        if($page == 0 || $page<1 ) {
              $showPostFrom = 0;
          }else {
              $showPostFrom = ($page * 30) - 30;
          }

        $data_query = mysqli_query($this->con, "SELECT * FROM forum_topics WHERE category='careers' ORDER BY id DESC LIMIT $showPostFrom, 30");
        $count = mysqli_num_rows($data_query);
        $PostsPerPage = $count/30;
        $PostsPerPage = ceil($PostsPerPage);

        if(mysqli_num_rows($data_query) > 0) {

            $num_iterations = 0; //Number of results checked (not necessarily posted)
            $count = 1;

            while($row = mysqli_fetch_array($data_query)) {
                $id = $row['id'];
                $post = $row['post'];
                $title = $row['title'];
                $category = $row['category'];
                $added_by = $row['posted_by'];
                $date_time = $row['date_posted'];
                $imagePath = $row['image_attachment'];
                $likes = $row['likes'];


                    if($userLoggedIn == $added_by || $userLoggedIn == admin)
                            $delete_button = "<button class='delete_button btn-danger' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='forum_post$id'>x</button>";
                    else
                        $delete_button = "";

                    if($userLoggedIn == admin)
                            $move_button = "<button class='move_button btn-success' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='move_forum_post$id'>m</button>";
                    else
                            $move_button = "";

                    $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
                    $user_row = mysqli_fetch_array($user_details_query);
                    $first_name = $user_row['first_name'];
                    $last_name = $user_row['last_name'];
                    $profile_pic = $user_row['profile_pic'];

                    ?>
                    <script>
                        function toggle<?php echo $id; ?>() {

                            var target = $(event.target);
                            if(!target.is("a")) {

                                var element = document.getElementById("toggleComment<?php echo $id; ?>");
                                if(element.style.display == "block")
                                    element.style.display = "none";
                                else
                                    element.style.display = "block";
                                }
                            }


                    </script>


                    <?php

                    $comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE forum_post_id='$id'");
                    $comments_check_num = mysqli_num_rows($comments_check);

                    //Timeframe
                    $date_time_now = date("Y-m-d H:i:s");
                    $start_date = new DateTime($date_time); //Time of post
                    $end_date = new DateTime($date_time_now); //Current time
                    $interval = $start_date->diff($end_date); //Difference between dates
                    if($interval->y >= 1) {
                        if($interval == 1)
                            $time_message = $interval->y." year ago"; //1 year ago
                        else
                            $time_message = $interval->y." years ago"; //1 year ago

                    }
                    else if($interval->m >= 1) {
                        if($interval->d == 0) {
                            $days = " ago";
                        }
                        else if($interval->d == 1) {
                            $days = $interval->d . " day ago";
                        }
                        else {
                            $days = $interval->d . " days ago";
                        }

                        if($interval->m == 1) {
                            $time_message = $interval->m . " month".$days;
                        }
                        else {
                            $time_message = $interval->m . " months".$days;
                        }
                    }

                    else if($interval->d >= 1) {
                        if($interval->d == 1) {
                            $time_message = "Yesterday";
                        }
                        else {
                            $time_message = $interval->d . " days ago";
                        }
                    }
                    else if($interval->h >= 1) {
                        if($interval->h == 1) {
                            $time_message = $interval->h . " hour ago";
                        }
                        else {
                            $time_message = $interval->h . " hours ago";
                        }
                    }

                    else if($interval->i >= 1) {
                        if($interval->i == 1) {
                            $time_message = $interval->i . " minute ago";
                        }
                        else {
                            $time_message = $interval->i . " minutes ago";
                        }
                    }

                    else {
                        if($interval->s < 30) {
                            $time_message = "Just now";
                        }
                        else {
                            $time_message = $interval->s . " seconds ago";
                        }
                    }

                    if($imagePath != "") {
                        $imageDiv = "<div class='postedImage'>
                                        <img src='$imagePath'>
                                    </div>";
                    }
                    else {
                        $imageDiv = "";
                    }

                    $str .= "<div class='forum_post' style='color:#ACACAC; border: 1px #D3D3D3 solid; padding:10px; text-align:center;'>


                                    <img src='$profile_pic' style='width:30px; height:30px; border-radius:15px; margin-right:10px;'><a href='post_details.php?forum_post_id=$id&page=1'><b> &laquo; $title &raquo; </b></a>
                                    <br><small style='font-size:11px;'>Posted by: $added_by &nbsp; $time_message &nbsp;&nbsp; Comments($comments_check_num) &nbsp;$delete_button&nbsp;&nbsp;$move_button</small>


                            </div>";

                            ?>
                            <script type="text/javascript">
                                $(document).ready(function() {

                                    $('#forum_post<?php echo $id; ?>').on('click', function(){
                                        bootbox.confirm("Are you sure you want to delete this post?", function(result) {
                                            $.post("includes/form_handlers/delete_forum_post.php?forum_post_id=<?php echo $id; ?>",
                                                {result:result});
                                            if(result)
                                                location.reload();

                                        });

                                    });

                                    $('#move_forum_post<?php echo $id; ?>').on('click', function(){
                                            bootbox.confirm("Are you sure you want to move this post to front page?", function(result) {
                                                $.post("includes/form_handlers/move_forum_post.php?move_forum_post_id=<?php echo $id; ?>",
                                                    {result:result});
                                                if(result)
                                                    location.reload();

                                            });

                                        });

                                });



                            </script>



                            <?php
                }
                }
        }

        echo $str;
    }


    public function loadTopicBusiness() {

      $userLoggedIn = $this->user_obj->getUsername();
        define("admin", "abigail_oba");

      $str = " "; //string to return

      if(isset($_GET['page'])) {
        $page = $_GET['page'];
        if($page == 0 || $page<1 ) {
              $showPostFrom = 0;
          }else {
              $showPostFrom = ($page * 30) - 30;
          }

        $data_query = mysqli_query($this->con, "SELECT * FROM forum_topics WHERE category='business' ORDER BY id DESC LIMIT $showPostFrom, 30");
        $count = mysqli_num_rows($data_query);
        $PostsPerPage = $count/30;
        $PostsPerPage = ceil($PostsPerPage);
        if(mysqli_num_rows($data_query) > 0) {

            $num_iterations = 0; //Number of results checked (not necessarily posted)
            $count = 1;

            while($row = mysqli_fetch_array($data_query)) {
                $id = $row['id'];
                $post = $row['post'];
                $title = $row['title'];
                $category = $row['category'];
                $added_by = $row['posted_by'];
                $date_time = $row['date_posted'];
                $imagePath = $row['image_attachment'];
                $likes = $row['likes'];


                    if($userLoggedIn == $added_by || $userLoggedIn == admin)
                            $delete_button = "<button class='delete_button btn-danger' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='forum_post$id'>x</button>";
                    else
                            $delete_button = "";

                    if($userLoggedIn == admin)
                            $move_button = "<button class='move_button btn-success' style='float: none; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='move_forum_post$id'>m</button>";
                    else
                            $move_button = "";

                    $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
                    $user_row = mysqli_fetch_array($user_details_query);
                    $first_name = $user_row['first_name'];
                    $last_name = $user_row['last_name'];
                    $profile_pic = $user_row['profile_pic'];

                    ?>
                    <script>
                        function toggle<?php echo $id; ?>() {

                            var target = $(event.target);
                            if(!target.is("a")) {

                                var element = document.getElementById("toggleComment<?php echo $id; ?>");
                                if(element.style.display == "block")
                                    element.style.display = "none";
                                else
                                    element.style.display = "block";
                                }
                            }


                    </script>


                    <?php

                    $comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE forum_post_id='$id'");
                    $comments_check_num = mysqli_num_rows($comments_check);

                    //Timeframe
                    $date_time_now = date("Y-m-d H:i:s");
                    $start_date = new DateTime($date_time); //Time of post
                    $end_date = new DateTime($date_time_now); //Current time
                    $interval = $start_date->diff($end_date); //Difference between dates
                    if($interval->y >= 1) {
                        if($interval == 1)
                            $time_message = $interval->y." year ago"; //1 year ago
                        else
                            $time_message = $interval->y." years ago"; //1 year ago

                    }
                    else if($interval->m >= 1) {
                        if($interval->d == 0) {
                            $days = " ago";
                        }
                        else if($interval->d == 1) {
                            $days = $interval->d . " day ago";
                        }
                        else {
                            $days = $interval->d . " days ago";
                        }

                        if($interval->m == 1) {
                            $time_message = $interval->m . " month".$days;
                        }
                        else {
                            $time_message = $interval->m . " months".$days;
                        }
                    }

                    else if($interval->d >= 1) {
                        if($interval->d == 1) {
                            $time_message = "Yesterday";
                        }
                        else {
                            $time_message = $interval->d . " days ago";
                        }
                    }
                    else if($interval->h >= 1) {
                        if($interval->h == 1) {
                            $time_message = $interval->h . " hour ago";
                        }
                        else {
                            $time_message = $interval->h . " hours ago";
                        }
                    }

                    else if($interval->i >= 1) {
                        if($interval->i == 1) {
                            $time_message = $interval->i . " minute ago";
                        }
                        else {
                            $time_message = $interval->i . " minutes ago";
                        }
                    }

                    else {
                        if($interval->s < 30) {
                            $time_message = "Just now";
                        }
                        else {
                            $time_message = $interval->s . " seconds ago";
                        }
                    }

                    if($imagePath != "") {
                        $imageDiv = "<div class='postedImage'>
                                        <img src='$imagePath'>
                                    </div>";
                    }
                    else {
                        $imageDiv = "";
                    }

                    $str .= "<div class='forum_post' style='color:#ACACAC; border: 1px #D3D3D3 solid; padding:10px; text-align:center;'>


                                    <img src='$profile_pic' style='width:30px; height:30px; border-radius:15px;'><a href='post_details.php?forum_post_id=$id&page=1'><b> &laquo; $title &raquo; </b></a>
                                    <br><small style='font-size:11px;'>Posted by: $added_by &nbsp; $time_message &nbsp;&nbsp; Comments($comments_check_num) &nbsp;$delete_button&nbsp;&nbsp;$move_button</small>


                            </div>";

                            ?>
                            <script type="text/javascript">
                                $(document).ready(function() {

                                    $('#forum_post<?php echo $id; ?>').on('click', function(){
                                        bootbox.confirm("Are you sure you want to delete this post?", function(result) {
                                            $.post("includes/form_handlers/delete_forum_post.php?forum_post_id=<?php echo $id; ?>",
                                                {result:result});
                                            if(result)
                                                location.reload();

                                        });

                                    });

                                    $('#move_forum_post<?php echo $id; ?>').on('click', function(){
                                        bootbox.confirm("Are you sure you want to move this post to front page?", function(result) {
                                            $.post("includes/form_handlers/move_forum_post.php?move_forum_post_id=<?php echo $id; ?>",
                                                {result:result});
                                            if(result)
                                                location.reload();

                                        });

                                    });


                                });



                            </script>



                            <?php
                }
              }
        }

        echo $str;
    }


    public function loadTopicInternational() {

      $userLoggedIn = $this->user_obj->getUsername();
        define("admin", "abigail_oba");

      $str = " "; //string to return

      if(isset($_GET['page'])) {
        $page = $_GET['page'];
        if($page == 0 || $page<1 ) {
              $showPostFrom = 0;
          }else {
              $showPostFrom = ($page * 30) - 30;
          }

        $data_query = mysqli_query($this->con, "SELECT * FROM forum_topics WHERE category='international' ORDER BY id DESC LIMIT $showPostFrom, 30");
        $count = mysqli_num_rows($data_query);
        $PostsPerPage = $count/30;
        $PostsPerPage = ceil($PostsPerPage);
        if(mysqli_num_rows($data_query) > 0) {

            $num_iterations = 0; //Number of results checked (not necessarily posted)
            $count = 1;

            while($row = mysqli_fetch_array($data_query)) {
                $id = $row['id'];
                $post = $row['post'];
                $title = $row['title'];
                $category = $row['category'];
                $added_by = $row['posted_by'];
                $date_time = $row['date_posted'];
                $imagePath = $row['image_attachment'];
                $likes = $row['likes'];


                    if($userLoggedIn == $added_by || $userLoggedIn == admin)
                            $delete_button = "<button class='delete_button btn-danger' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='forum_post$id'>x</button>";
                        else
                            $delete_button = "";

                        if($userLoggedIn == admin)
                            $move_button = "<button class='move_button btn-success' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='move_forum_post$id'>m</button>";
                        else
                            $move_button = "";

                    $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
                    $user_row = mysqli_fetch_array($user_details_query);
                    $first_name = $user_row['first_name'];
                    $last_name = $user_row['last_name'];
                    $profile_pic = $user_row['profile_pic'];

                    ?>
                    <script>
                        function toggle<?php echo $id; ?>() {

                            var target = $(event.target);
                            if(!target.is("a")) {

                                var element = document.getElementById("toggleComment<?php echo $id; ?>");
                                if(element.style.display == "block")
                                    element.style.display = "none";
                                else
                                    element.style.display = "block";
                                }
                            }


                    </script>


                    <?php

                    $comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE forum_post_id='$id'");
                    $comments_check_num = mysqli_num_rows($comments_check);

                    //Timeframe
                    $date_time_now = date("Y-m-d H:i:s");
                    $start_date = new DateTime($date_time); //Time of post
                    $end_date = new DateTime($date_time_now); //Current time
                    $interval = $start_date->diff($end_date); //Difference between dates
                    if($interval->y >= 1) {
                        if($interval == 1)
                            $time_message = $interval->y." year ago"; //1 year ago
                        else
                            $time_message = $interval->y." years ago"; //1 year ago

                    }
                    else if($interval->m >= 1) {
                        if($interval->d == 0) {
                            $days = " ago";
                        }
                        else if($interval->d == 1) {
                            $days = $interval->d . " day ago";
                        }
                        else {
                            $days = $interval->d . " days ago";
                        }

                        if($interval->m == 1) {
                            $time_message = $interval->m . " month".$days;
                        }
                        else {
                            $time_message = $interval->m . " months".$days;
                        }
                    }

                    else if($interval->d >= 1) {
                        if($interval->d == 1) {
                            $time_message = "Yesterday";
                        }
                        else {
                            $time_message = $interval->d . " days ago";
                        }
                    }
                    else if($interval->h >= 1) {
                        if($interval->h == 1) {
                            $time_message = $interval->h . " hour ago";
                        }
                        else {
                            $time_message = $interval->h . " hours ago";
                        }
                    }

                    else if($interval->i >= 1) {
                        if($interval->i == 1) {
                            $time_message = $interval->i . " minute ago";
                        }
                        else {
                            $time_message = $interval->i . " minutes ago";
                        }
                    }

                    else {
                        if($interval->s < 30) {
                            $time_message = "Just now";
                        }
                        else {
                            $time_message = $interval->s . " seconds ago";
                        }
                    }

                    if($imagePath != "") {
                        $imageDiv = "<div class='postedImage'>
                                        <img src='$imagePath'>
                                    </div>";
                    }
                    else {
                        $imageDiv = "";
                    }

                    $str .= "<div class='forum_post' style='color:#ACACAC; border: 1px #D3D3D3 solid; padding:10px; text-align:center;'>


                                    <img src='$profile_pic' style='width:30px; height:30px; border-radius:15px;'><a href='post_details.php?forum_post_id=$id&page=1'><b> &laquo; $title &raquo; </b></a>
                                    <br><small style='font-size:11px;'>Posted by: $added_by &nbsp; $time_message &nbsp;&nbsp; Comments($comments_check_num) &nbsp;$delete_button&nbsp;&nbsp;$move_button</small>


                            </div>";

                            ?>
                            <script type="text/javascript">
                                $(document).ready(function() {

                                    $('#forum_post<?php echo $id; ?>').on('click', function(){
                                        bootbox.confirm("Are you sure you want to delete this post?", function(result) {
                                            $.post("includes/form_handlers/delete_forum_post.php?forum_post_id=<?php echo $id; ?>",
                                                {result:result});
                                            if(result)
                                                location.reload();

                                        });

                                    });

                                    $('#move_forum_post<?php echo $id; ?>').on('click', function(){
                                        bootbox.confirm("Are you sure you want to move this post to front page?", function(result) {
                                            $.post("includes/form_handlers/move_forum_post.php?move_forum_post_id=<?php echo $id; ?>",
                                                {result:result});
                                            if(result)
                                                location.reload();

                                        });

                                    });

                                });



                            </script>



                            <?php
                }
              }
        }

        echo $str;
    }

    public function loadTopicReligion() {

      $userLoggedIn = $this->user_obj->getUsername();
        define("admin", "abigail_oba");

      $str = " "; //string to return

      if(isset($_GET['page'])) {
        $page = $_GET['page'];
        if($page == 0 || $page<1 ) {
              $showPostFrom = 0;
          }else {
              $showPostFrom = ($page * 30) - 30;
          }

        $data_query = mysqli_query($this->con, "SELECT * FROM forum_topics WHERE category='religion' ORDER BY id DESC LIMIT $showPostFrom, 30");
        $count = mysqli_num_rows($data_query);
        $PostsPerPage = $count/30;
        $PostsPerPage = ceil($PostsPerPage);
        if(mysqli_num_rows($data_query) > 0) {

            $num_iterations = 0; //Number of results checked (not necessarily posted)
            $count = 1;

            while($row = mysqli_fetch_array($data_query)) {
                $id = $row['id'];
                $post = $row['post'];
                $title = $row['title'];
                $category = $row['category'];
                $added_by = $row['posted_by'];
                $date_time = $row['date_posted'];
                $imagePath = $row['image_attachment'];
                $likes = $row['likes'];


                      if($userLoggedIn == $added_by || $userLoggedIn == admin)
                            $delete_button = "<button class='delete_button btn-danger' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='forum_post$id'>x</button>";
                        else
                            $delete_button = "";

                        if($userLoggedIn == admin)
                            $move_button = "<button class='move_button btn-success' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='move_forum_post$id'>m</button>";
                        else
                            $move_button = "";

                    $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
                    $user_row = mysqli_fetch_array($user_details_query);
                    $first_name = $user_row['first_name'];
                    $last_name = $user_row['last_name'];
                    $profile_pic = $user_row['profile_pic'];

                    ?>
                    <script>
                        function toggle<?php echo $id; ?>() {

                            var target = $(event.target);
                            if(!target.is("a")) {

                                var element = document.getElementById("toggleComment<?php echo $id; ?>");
                                if(element.style.display == "block")
                                    element.style.display = "none";
                                else
                                    element.style.display = "block";
                                }
                            }


                    </script>


                    <?php

                    $comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE forum_post_id='$id'");
                    $comments_check_num = mysqli_num_rows($comments_check);

                    //Timeframe
                    $date_time_now = date("Y-m-d H:i:s");
                    $start_date = new DateTime($date_time); //Time of post
                    $end_date = new DateTime($date_time_now); //Current time
                    $interval = $start_date->diff($end_date); //Difference between dates
                    if($interval->y >= 1) {
                        if($interval == 1)
                            $time_message = $interval->y." year ago"; //1 year ago
                        else
                            $time_message = $interval->y." years ago"; //1 year ago

                    }
                    else if($interval->m >= 1) {
                        if($interval->d == 0) {
                            $days = " ago";
                        }
                        else if($interval->d == 1) {
                            $days = $interval->d . " day ago";
                        }
                        else {
                            $days = $interval->d . " days ago";
                        }

                        if($interval->m == 1) {
                            $time_message = $interval->m . " month".$days;
                        }
                        else {
                            $time_message = $interval->m . " months".$days;
                        }
                    }

                    else if($interval->d >= 1) {
                        if($interval->d == 1) {
                            $time_message = "Yesterday";
                        }
                        else {
                            $time_message = $interval->d . " days ago";
                        }
                    }
                    else if($interval->h >= 1) {
                        if($interval->h == 1) {
                            $time_message = $interval->h . " hour ago";
                        }
                        else {
                            $time_message = $interval->h . " hours ago";
                        }
                    }

                    else if($interval->i >= 1) {
                        if($interval->i == 1) {
                            $time_message = $interval->i . " minute ago";
                        }
                        else {
                            $time_message = $interval->i . " minutes ago";
                        }
                    }

                    else {
                        if($interval->s < 30) {
                            $time_message = "Just now";
                        }
                        else {
                            $time_message = $interval->s . " seconds ago";
                        }
                    }

                    if($imagePath != "") {
                        $imageDiv = "<div class='postedImage'>
                                        <img src='$imagePath'>
                                    </div>";
                    }
                    else {
                        $imageDiv = "";
                    }

                    $str .= "<div class='forum_post' style='color:#ACACAC; border: 1px #D3D3D3 solid; padding:10px; text-align:center;'>


                                    <img src='$profile_pic' style='width:30px; height:30px; border-radius:15px;'><a href='post_details.php?forum_post_id=$id&page=1'><b> &laquo; $title &raquo; </b></a>
                                    <br><small style='font-size:11px;'>Posted by: $added_by &nbsp; $time_message &nbsp;&nbsp; Comments($comments_check_num) &nbsp;$delete_button&nbsp;&nbsp;$move_button</small>


                            </div>";

                            ?>
                            <script type="text/javascript">
                                $(document).ready(function() {

                                    $('#forum_post<?php echo $id; ?>').on('click', function(){
                                        bootbox.confirm("Are you sure you want to delete this post?", function(result) {
                                            $.post("includes/form_handlers/delete_forum_post.php?forum_post_id=<?php echo $id; ?>",
                                                {result:result});
                                            if(result)
                                                location.reload();

                                        });

                                    });

                                    $('#move_forum_post<?php echo $id; ?>').on('click', function(){
                                        bootbox.confirm("Are you sure you want to move this post to front page?", function(result) {
                                            $.post("includes/form_handlers/move_forum_post.php?move_forum_post_id=<?php echo $id; ?>",
                                                    {result:result});
                                            if(result)
                                                location.reload();

                                            });

                                        });

                                });



                            </script>



                            <?php
                }
                }
        }

        echo $str;
    }

    public function loadTopicEntertainment() {

      $userLoggedIn = $this->user_obj->getUsername();
        define("admin", "abigail_oba");

      $str = " "; //string to return

      if(isset($_GET['page'])) {
        $page = $_GET['page'];
        if($page == 0 || $page<1 ) {
              $showPostFrom = 0;
          }else {
              $showPostFrom = ($page * 30) - 30;
          }

        $data_query = mysqli_query($this->con, "SELECT * FROM forum_topics WHERE category='entertainment' ORDER BY id DESC LIMIT $showPostFrom, 30");
        $count = mysqli_num_rows($data_query);
        $PostsPerPage = $count/30;
        $PostsPerPage = ceil($PostsPerPage);
        if(mysqli_num_rows($data_query) > 0) {

            $num_iterations = 0; //Number of results checked (not necessarily posted)
            $count = 1;

            while($row = mysqli_fetch_array($data_query)) {
                $id = $row['id'];
                $post = $row['post'];
                $title = $row['title'];
                $category = $row['category'];
                $added_by = $row['posted_by'];
                $date_time = $row['date_posted'];
                $imagePath = $row['image_attachment'];
                $likes = $row['likes'];


                    if($userLoggedIn == $added_by || $userLoggedIn == admin)
                            $delete_button = "<button class='delete_button btn-danger' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='forum_post$id'>x</button>";
                        else
                            $delete_button = "";

                        if($userLoggedIn == admin)
                            $move_button = "<button class='move_button btn-success' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='move_forum_post$id'>m</button>";
                        else
                            $move_button = "";

                    $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
                    $user_row = mysqli_fetch_array($user_details_query);
                    $first_name = $user_row['first_name'];
                    $last_name = $user_row['last_name'];
                    $profile_pic = $user_row['profile_pic'];

                    ?>
                    <script>
                        function toggle<?php echo $id; ?>() {

                            var target = $(event.target);
                            if(!target.is("a")) {

                                var element = document.getElementById("toggleComment<?php echo $id; ?>");
                                if(element.style.display == "block")
                                    element.style.display = "none";
                                else
                                    element.style.display = "block";
                                }
                            }


                    </script>


                    <?php

                    $comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE forum_post_id='$id'");
                    $comments_check_num = mysqli_num_rows($comments_check);

                    //Timeframe
                    $date_time_now = date("Y-m-d H:i:s");
                    $start_date = new DateTime($date_time); //Time of post
                    $end_date = new DateTime($date_time_now); //Current time
                    $interval = $start_date->diff($end_date); //Difference between dates
                    if($interval->y >= 1) {
                        if($interval == 1)
                            $time_message = $interval->y." year ago"; //1 year ago
                        else
                            $time_message = $interval->y." years ago"; //1 year ago

                    }
                    else if($interval->m >= 1) {
                        if($interval->d == 0) {
                            $days = " ago";
                        }
                        else if($interval->d == 1) {
                            $days = $interval->d . " day ago";
                        }
                        else {
                            $days = $interval->d . " days ago";
                        }

                        if($interval->m == 1) {
                            $time_message = $interval->m . " month".$days;
                        }
                        else {
                            $time_message = $interval->m . " months".$days;
                        }
                    }

                    else if($interval->d >= 1) {
                        if($interval->d == 1) {
                            $time_message = "Yesterday";
                        }
                        else {
                            $time_message = $interval->d . " days ago";
                        }
                    }
                    else if($interval->h >= 1) {
                        if($interval->h == 1) {
                            $time_message = $interval->h . " hour ago";
                        }
                        else {
                            $time_message = $interval->h . " hours ago";
                        }
                    }

                    else if($interval->i >= 1) {
                        if($interval->i == 1) {
                            $time_message = $interval->i . " minute ago";
                        }
                        else {
                            $time_message = $interval->i . " minutes ago";
                        }
                    }

                    else {
                        if($interval->s < 30) {
                            $time_message = "Just now";
                        }
                        else {
                            $time_message = $interval->s . " seconds ago";
                        }
                    }

                    if($imagePath != "") {
                        $imageDiv = "<div class='postedImage'>
                                        <img src='$imagePath'>
                                    </div>";
                    }
                    else {
                        $imageDiv = "";
                    }

                    $str .= "<div class='forum_post' style='color:#ACACAC; border: 1px #D3D3D3 solid; padding:10px; text-align:center;'>


                                    <img src='$profile_pic' style='width:30px; height:30px; border-radius:15px;'><a href='post_details.php?forum_post_id=$id&page=1'><b> &laquo; $title &raquo; </b></a>
                                    <br><small style='font-size:11px;'>Posted by: $added_by &nbsp; $time_message &nbsp;&nbsp; Comments($comments_check_num) &nbsp;$delete_button&nbsp;&nbsp;$move_button</small>


                            </div>";

                            ?>
                            <script type="text/javascript">
                                $(document).ready(function() {

                                    $('#forum_post<?php echo $id; ?>').on('click', function(){
                                        bootbox.confirm("Are you sure you want to delete this post?", function(result) {
                                            $.post("includes/form_handlers/delete_forum_post.php?forum_post_id=<?php echo $id; ?>",
                                                {result:result});
                                            if(result)
                                                location.reload();

                                        });

                                    });

                                    $('#move_forum_post<?php echo $id; ?>').on('click', function(){
                                        bootbox.confirm("Are you sure you want to move this post to front page?", function(result) {
                                            $.post("includes/form_handlers/move_forum_post.php?move_forum_post_id=<?php echo $id; ?>",
                                                {result:result});
                                            if(result)
                                                location.reload();

                                        });

                                    });

                                });



                            </script>



                            <?php
                }
                }
        }

        echo $str;
    }

    public function loadTopicEducation() {

      $userLoggedIn = $this->user_obj->getUsername();
        define("admin", "abigail_oba");

      $str = " "; //string to return

      if(isset($_GET['page'])) {
        $page = $_GET['page'];
        if($page == 0 || $page<1 ) {
              $showPostFrom = 0;
          }else {
              $showPostFrom = ($page * 30) - 30;
          }

        $data_query = mysqli_query($this->con, "SELECT * FROM forum_topics WHERE category='education' ORDER BY id DESC LIMIT $showPostFrom, 30");
        $count = mysqli_num_rows($data_query);
        $PostsPerPage = $count/30;
        $PostsPerPage = ceil($PostsPerPage);
        if(mysqli_num_rows($data_query) > 0) {

            $num_iterations = 0; //Number of results checked (not necessarily posted)
            $count = 1;

            while($row = mysqli_fetch_array($data_query)) {
                $id = $row['id'];
                $post = $row['post'];
                $title = $row['title'];
                $category = $row['category'];
                $added_by = $row['posted_by'];
                $date_time = $row['date_posted'];
                $imagePath = $row['image_attachment'];
                $likes = $row['likes'];


                    if($userLoggedIn == $added_by || $userLoggedIn == admin)
                            $delete_button = "<button class='delete_button btn-danger' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='forum_post$id'>x</button>";
                        else
                            $delete_button = "";

                        if($userLoggedIn == admin)
                            $move_button = "<button class='move_button btn-success' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='move_forum_post$id'>m</button>";
                        else
                            $move_button = "";

                    $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
                    $user_row = mysqli_fetch_array($user_details_query);
                    $first_name = $user_row['first_name'];
                    $last_name = $user_row['last_name'];
                    $profile_pic = $user_row['profile_pic'];

                    ?>
                    <script>
                        function toggle<?php echo $id; ?>() {

                            var target = $(event.target);
                            if(!target.is("a")) {

                                var element = document.getElementById("toggleComment<?php echo $id; ?>");
                                if(element.style.display == "block")
                                    element.style.display = "none";
                                else
                                    element.style.display = "block";
                                }
                            }


                    </script>


                    <?php

                    $comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE forum_post_id='$id'");
                    $comments_check_num = mysqli_num_rows($comments_check);

                    //Timeframe
                    $date_time_now = date("Y-m-d H:i:s");
                    $start_date = new DateTime($date_time); //Time of post
                    $end_date = new DateTime($date_time_now); //Current time
                    $interval = $start_date->diff($end_date); //Difference between dates
                    if($interval->y >= 1) {
                        if($interval == 1)
                            $time_message = $interval->y." year ago"; //1 year ago
                        else
                            $time_message = $interval->y." years ago"; //1 year ago

                    }
                    else if($interval->m >= 1) {
                        if($interval->d == 0) {
                            $days = " ago";
                        }
                        else if($interval->d == 1) {
                            $days = $interval->d . " day ago";
                        }
                        else {
                            $days = $interval->d . " days ago";
                        }

                        if($interval->m == 1) {
                            $time_message = $interval->m . " month".$days;
                        }
                        else {
                            $time_message = $interval->m . " months".$days;
                        }
                    }

                    else if($interval->d >= 1) {
                        if($interval->d == 1) {
                            $time_message = "Yesterday";
                        }
                        else {
                            $time_message = $interval->d . " days ago";
                        }
                    }
                    else if($interval->h >= 1) {
                        if($interval->h == 1) {
                            $time_message = $interval->h . " hour ago";
                        }
                        else {
                            $time_message = $interval->h . " hours ago";
                        }
                    }

                    else if($interval->i >= 1) {
                        if($interval->i == 1) {
                            $time_message = $interval->i . " minute ago";
                        }
                        else {
                            $time_message = $interval->i . " minutes ago";
                        }
                    }

                    else {
                        if($interval->s < 30) {
                            $time_message = "Just now";
                        }
                        else {
                            $time_message = $interval->s . " seconds ago";
                        }
                    }

                    if($imagePath != "") {
                        $imageDiv = "<div class='postedImage'>
                                        <img src='$imagePath'>
                                    </div>";
                    }
                    else {
                        $imageDiv = "";
                    }

                    $str .= "<div class='forum_post' style='color:#ACACAC; border: 1px #D3D3D3 solid; padding:10px; text-align:center;'>


                                    <img src='$profile_pic' style='width:30px; height:30px; border-radius:15px;'><a href='post_details.php?forum_post_id=$id&page=1'><b> &laquo; $title &raquo; </b></a>
                                    <br><small style='font-size:11px;'>Posted by: $added_by &nbsp; $time_message &nbsp;&nbsp; Comments($comments_check_num) &nbsp;$delete_button&nbsp;&nbsp;$move_button</small>


                            </div>";

                            ?>
                            <script type="text/javascript">
                                $(document).ready(function() {

                                    $('#forum_post<?php echo $id; ?>').on('click', function(){
                                        bootbox.confirm("Are you sure you want to delete this post?", function(result) {
                                            $.post("includes/form_handlers/delete_forum_post.php?forum_post_id=<?php echo $id; ?>",
                                                {result:result});
                                            if(result)
                                                location.reload();

                                        });

                                    });

                                    $('#move_forum_post<?php echo $id; ?>').on('click', function(){
                                        bootbox.confirm("Are you sure you want to move this post to front page?", function(result) {
                                            $.post("includes/form_handlers/move_forum_post.php?move_forum_post_id=<?php echo $id; ?>",
                                                {result:result});
                                            if(result)
                                                location.reload();

                                        });

                                    });

                                });



                            </script>



                            <?php
                }
                }
        }

        echo $str;
    }

    public function loadTopicScienceAndTechnology() {

      $userLoggedIn = $this->user_obj->getUsername();
        define("admin", "abigail_oba");

      $str = " "; //string to return

      if(isset($_GET['page'])) {
        $page = $_GET['page'];
        if($page == 0 || $page<1 ) {
              $showPostFrom = 0;
          }else {
              $showPostFrom = ($page * 30) - 30;
          }

        $data_query = mysqli_query($this->con, "SELECT * FROM forum_topics WHERE category='scienceandtechnology' ORDER BY id DESC LIMIT $showPostFrom, 30");
        $count = mysqli_num_rows($data_query);
        $PostsPerPage = $count/30;
        $PostsPerPage = ceil($PostsPerPage);
        if(mysqli_num_rows($data_query) > 0) {

            $num_iterations = 0; //Number of results checked (not necessarily posted)
            $count = 1;

            while($row = mysqli_fetch_array($data_query)) {
                $id = $row['id'];
                $post = $row['post'];
                $title = $row['title'];
                $category = $row['category'];
                $added_by = $row['posted_by'];
                $date_time = $row['date_posted'];
                $imagePath = $row['image_attachment'];
                $likes = $row['likes'];


                    if($userLoggedIn == $added_by || $userLoggedIn == admin)
                            $delete_button = "<button class='delete_button btn-danger' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='forum_post$id'>x</button>";
                        else
                            $delete_button = "";

                        if($userLoggedIn == admin)
                            $move_button = "<button class='move_button btn-success' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='move_forum_post$id'>m</button>";
                        else
                            $move_button = "";

                    $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
                    $user_row = mysqli_fetch_array($user_details_query);
                    $first_name = $user_row['first_name'];
                    $last_name = $user_row['last_name'];
                    $profile_pic = $user_row['profile_pic'];

                    ?>
                    <script>
                        function toggle<?php echo $id; ?>() {

                            var target = $(event.target);
                            if(!target.is("a")) {

                                var element = document.getElementById("toggleComment<?php echo $id; ?>");
                                if(element.style.display == "block")
                                    element.style.display = "none";
                                else
                                    element.style.display = "block";
                                }
                            }


                    </script>


                    <?php

                    $comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE forum_post_id='$id'");
                    $comments_check_num = mysqli_num_rows($comments_check);

                    //Timeframe
                    $date_time_now = date("Y-m-d H:i:s");
                    $start_date = new DateTime($date_time); //Time of post
                    $end_date = new DateTime($date_time_now); //Current time
                    $interval = $start_date->diff($end_date); //Difference between dates
                    if($interval->y >= 1) {
                        if($interval == 1)
                            $time_message = $interval->y." year ago"; //1 year ago
                        else
                            $time_message = $interval->y." years ago"; //1 year ago

                    }
                    else if($interval->m >= 1) {
                        if($interval->d == 0) {
                            $days = " ago";
                        }
                        else if($interval->d == 1) {
                            $days = $interval->d . " day ago";
                        }
                        else {
                            $days = $interval->d . " days ago";
                        }

                        if($interval->m == 1) {
                            $time_message = $interval->m . " month".$days;
                        }
                        else {
                            $time_message = $interval->m . " months".$days;
                        }
                    }

                    else if($interval->d >= 1) {
                        if($interval->d == 1) {
                            $time_message = "Yesterday";
                        }
                        else {
                            $time_message = $interval->d . " days ago";
                        }
                    }
                    else if($interval->h >= 1) {
                        if($interval->h == 1) {
                            $time_message = $interval->h . " hour ago";
                        }
                        else {
                            $time_message = $interval->h . " hours ago";
                        }
                    }

                    else if($interval->i >= 1) {
                        if($interval->i == 1) {
                            $time_message = $interval->i . " minute ago";
                        }
                        else {
                            $time_message = $interval->i . " minutes ago";
                        }
                    }

                    else {
                        if($interval->s < 30) {
                            $time_message = "Just now";
                        }
                        else {
                            $time_message = $interval->s . " seconds ago";
                        }
                    }

                    if($imagePath != "") {
                        $imageDiv = "<div class='postedImage'>
                                        <img src='$imagePath'>
                                    </div>";
                    }
                    else {
                        $imageDiv = "";
                    }

                    $str .= "<div class='forum_post' style='color:#ACACAC; border: 1px #D3D3D3 solid; padding:10px; text-align:center;'>


                                    <img src='$profile_pic' style='width:30px; height:30px; border-radius:15px;'><a href='post_details.php?forum_post_id=$id&page=1'><b> &laquo; $title &raquo; </b></a>
                                    <br><small style='font-size:11px;'>Posted by: $added_by &nbsp; $time_message &nbsp;&nbsp; Comments($comments_check_num) &nbsp;$delete_button&nbsp;&nbsp;$move_button</small>


                            </div>";

                            ?>
                            <script type="text/javascript">
                                $(document).ready(function() {

                                    $('#forum_post<?php echo $id; ?>').on('click', function(){
                                        bootbox.confirm("Are you sure you want to delete this post?", function(result) {
                                            $.post("includes/form_handlers/delete_forum_post.php?forum_post_id=<?php echo $id; ?>",
                                                {result:result});
                                            if(result)
                                                location.reload();

                                        });

                                    });

                                    $('#move_forum_post<?php echo $id; ?>').on('click', function(){
                                        bootbox.confirm("Are you sure you want to move this post to front page?", function(result) {
                                            $.post("includes/form_handlers/move_forum_post.php?move_forum_post_id=<?php echo $id; ?>",
                                                {result:result});
                                            if(result)
                                                location.reload();

                                        });

                                    });


                                });



                            </script>



                            <?php
                }
                }
        }

        echo $str;
    }

    public function loadTopicArtsAndLiterature() {

      $userLoggedIn = $this->user_obj->getUsername();
        define("admin", "abigail_oba");

      $str = " "; //string to return

      if(isset($_GET['page'])) {
        $page = $_GET['page'];
        if($page == 0 || $page<1 ) {
              $showPostFrom = 0;
          }else {
              $showPostFrom = ($page * 30) - 30;
          }

        $data_query = mysqli_query($this->con, "SELECT * FROM forum_topics WHERE category='artsandliterature' ORDER BY id DESC LIMIT $showPostFrom, 30");
        $count = mysqli_num_rows($data_query);
        $PostsPerPage = $count/30;
        $PostsPerPage = ceil($PostsPerPage);
        if(mysqli_num_rows($data_query) > 0) {

            $num_iterations = 0; //Number of results checked (not necessarily posted)
            $count = 1;

            while($row = mysqli_fetch_array($data_query)) {
                $id = $row['id'];
                $post = $row['post'];
                $title = $row['title'];
                $category = $row['category'];
                $added_by = $row['posted_by'];
                $date_time = $row['date_posted'];
                $imagePath = $row['image_attachment'];
                $likes = $row['likes'];


                    if($userLoggedIn == $added_by || $userLoggedIn == admin)
                            $delete_button = "<button class='delete_button btn-danger' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='forum_post$id'>x</button>";
                        else
                            $delete_button = "";

                        if($userLoggedIn == admin)
                            $move_button = "<button class='move_button btn-success' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='move_forum_post$id'>m</button>";
                        else
                            $move_button = "";
                    $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
                    $user_row = mysqli_fetch_array($user_details_query);
                    $first_name = $user_row['first_name'];
                    $last_name = $user_row['last_name'];
                    $profile_pic = $user_row['profile_pic'];

                    ?>
                    <script>
                        function toggle<?php echo $id; ?>() {

                            var target = $(event.target);
                            if(!target.is("a")) {

                                var element = document.getElementById("toggleComment<?php echo $id; ?>");
                                if(element.style.display == "block")
                                    element.style.display = "none";
                                else
                                    element.style.display = "block";
                                }
                            }


                    </script>


                    <?php

                    $comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE forum_post_id='$id'");
                    $comments_check_num = mysqli_num_rows($comments_check);

                    //Timeframe
                    $date_time_now = date("Y-m-d H:i:s");
                    $start_date = new DateTime($date_time); //Time of post
                    $end_date = new DateTime($date_time_now); //Current time
                    $interval = $start_date->diff($end_date); //Difference between dates
                    if($interval->y >= 1) {
                        if($interval == 1)
                            $time_message = $interval->y." year ago"; //1 year ago
                        else
                            $time_message = $interval->y." years ago"; //1 year ago

                    }
                    else if($interval->m >= 1) {
                        if($interval->d == 0) {
                            $days = " ago";
                        }
                        else if($interval->d == 1) {
                            $days = $interval->d . " day ago";
                        }
                        else {
                            $days = $interval->d . " days ago";
                        }

                        if($interval->m == 1) {
                            $time_message = $interval->m . " month".$days;
                        }
                        else {
                            $time_message = $interval->m . " months".$days;
                        }
                    }

                    else if($interval->d >= 1) {
                        if($interval->d == 1) {
                            $time_message = "Yesterday";
                        }
                        else {
                            $time_message = $interval->d . " days ago";
                        }
                    }
                    else if($interval->h >= 1) {
                        if($interval->h == 1) {
                            $time_message = $interval->h . " hour ago";
                        }
                        else {
                            $time_message = $interval->h . " hours ago";
                        }
                    }

                    else if($interval->i >= 1) {
                        if($interval->i == 1) {
                            $time_message = $interval->i . " minute ago";
                        }
                        else {
                            $time_message = $interval->i . " minutes ago";
                        }
                    }

                    else {
                        if($interval->s < 30) {
                            $time_message = "Just now";
                        }
                        else {
                            $time_message = $interval->s . " seconds ago";
                        }
                    }

                    if($imagePath != "") {
                        $imageDiv = "<div class='postedImage'>
                                        <img src='$imagePath'>
                                    </div>";
                    }
                    else {
                        $imageDiv = "";
                    }

                    $str .= "<div class='forum_post' style='color:#ACACAC; border: 1px #D3D3D3 solid; padding:10px; text-align:center;'>


                                    <img src='$profile_pic' style='width:30px; height:30px; border-radius:15px;'><a href='post_details.php?forum_post_id=$id&page=1'><b> &laquo; $title &raquo; </b></a>
                                    <br><small style='font-size:11px;'>Posted by: $added_by &nbsp; $time_message &nbsp;&nbsp; Comments($comments_check_num) &nbsp;$delete_button&nbsp;&nbsp;$move_button</small>


                            </div>";

                            ?>
                            <script type="text/javascript">
                                $(document).ready(function() {

                                    $('#forum_post<?php echo $id; ?>').on('click', function(){
                                        bootbox.confirm("Are you sure you want to delete this post?", function(result) {
                                            $.post("includes/form_handlers/delete_forum_post.php?forum_post_id=<?php echo $id; ?>",
                                                {result:result});
                                            if(result)
                                                location.reload();

                                        });

                                    });

                                    $('#move_forum_post<?php echo $id; ?>').on('click', function(){
                                            bootbox.confirm("Are you sure you want to move this post to front page?", function(result) {
                                                $.post("includes/form_handlers/move_forum_post.php?move_forum_post_id=<?php echo $id; ?>",
                                                    {result:result});
                                                if(result)
                                                    location.reload();

                                            });

                                        });

                                });



                            </script>



                            <?php
                }
                }
        }

        echo $str;
    }

    public function loadTopicRomanceAndRelationships() {

      $userLoggedIn = $this->user_obj->getUsername();
        define("admin", "abigail_oba");

      $str = " "; //string to return

      if(isset($_GET['page'])) {
        $page = $_GET['page'];
        if($page == 0 || $page<1 ) {
              $showPostFrom = 0;
          }else {
              $showPostFrom = ($page * 30) - 30;
          }

        $data_query = mysqli_query($this->con, "SELECT * FROM forum_topics WHERE category='romanceandrelationships' ORDER BY id DESC LIMIT $showPostFrom, 30");
        $count = mysqli_num_rows($data_query);
        $PostsPerPage = $count/30;
        $PostsPerPage = ceil($PostsPerPage);
        if(mysqli_num_rows($data_query) > 0) {

            $num_iterations = 0; //Number of results checked (not necessarily posted)
            $count = 1;

            while($row = mysqli_fetch_array($data_query)) {
                $id = $row['id'];
                $post = $row['post'];
                $title = $row['title'];
                $category = $row['category'];
                $added_by = $row['posted_by'];
                $date_time = $row['date_posted'];
                $imagePath = $row['image_attachment'];
                $likes = $row['likes'];


                    if($userLoggedIn == $added_by || $userLoggedIn == admin)
                            $delete_button = "<button class='delete_button btn-danger' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='forum_post$id'>x</button>";
                        else
                            $delete_button = "";

                        if($userLoggedIn == admin)
                            $move_button = "<button class='move_button btn-success' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='move_forum_post$id'>m</button>";
                        else
                            $move_button = "";

                    $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
                    $user_row = mysqli_fetch_array($user_details_query);
                    $first_name = $user_row['first_name'];
                    $last_name = $user_row['last_name'];
                    $profile_pic = $user_row['profile_pic'];

                    ?>
                    <script>
                        function toggle<?php echo $id; ?>() {

                            var target = $(event.target);
                            if(!target.is("a")) {

                                var element = document.getElementById("toggleComment<?php echo $id; ?>");
                                if(element.style.display == "block")
                                    element.style.display = "none";
                                else
                                    element.style.display = "block";
                                }
                            }


                    </script>


                    <?php

                    $comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE forum_post_id='$id'");
                    $comments_check_num = mysqli_num_rows($comments_check);

                    //Timeframe
                    $date_time_now = date("Y-m-d H:i:s");
                    $start_date = new DateTime($date_time); //Time of post
                    $end_date = new DateTime($date_time_now); //Current time
                    $interval = $start_date->diff($end_date); //Difference between dates
                    if($interval->y >= 1) {
                        if($interval == 1)
                            $time_message = $interval->y." year ago"; //1 year ago
                        else
                            $time_message = $interval->y." years ago"; //1 year ago

                    }
                    else if($interval->m >= 1) {
                        if($interval->d == 0) {
                            $days = " ago";
                        }
                        else if($interval->d == 1) {
                            $days = $interval->d . " day ago";
                        }
                        else {
                            $days = $interval->d . " days ago";
                        }

                        if($interval->m == 1) {
                            $time_message = $interval->m . " month".$days;
                        }
                        else {
                            $time_message = $interval->m . " months".$days;
                        }
                    }

                    else if($interval->d >= 1) {
                        if($interval->d == 1) {
                            $time_message = "Yesterday";
                        }
                        else {
                            $time_message = $interval->d . " days ago";
                        }
                    }
                    else if($interval->h >= 1) {
                        if($interval->h == 1) {
                            $time_message = $interval->h . " hour ago";
                        }
                        else {
                            $time_message = $interval->h . " hours ago";
                        }
                    }

                    else if($interval->i >= 1) {
                        if($interval->i == 1) {
                            $time_message = $interval->i . " minute ago";
                        }
                        else {
                            $time_message = $interval->i . " minutes ago";
                        }
                    }

                    else {
                        if($interval->s < 30) {
                            $time_message = "Just now";
                        }
                        else {
                            $time_message = $interval->s . " seconds ago";
                        }
                    }

                    if($imagePath != "") {
                        $imageDiv = "<div class='postedImage'>
                                        <img src='$imagePath'>
                                    </div>";
                    }
                    else {
                        $imageDiv = "";
                    }

                    $str .= "<div class='forum_post' style='color:#ACACAC; border: 1px #D3D3D3 solid; padding:10px; text-align:center;'>


                                    <img src='$profile_pic' style='width:30px; height:30px; border-radius:15px;'><a href='post_details.php?forum_post_id=$id&page=1'><b> &laquo; $title &raquo; </b></a>
                                    <br><small style='font-size:11px;'>Posted by: $added_by &nbsp; $time_message &nbsp;&nbsp; Comments($comments_check_num) &nbsp;$delete_button&nbsp;&nbsp;$move_button</small>


                            </div>";

                            ?>
                            <script type="text/javascript">
                                $(document).ready(function() {

                                    $('#forum_post<?php echo $id; ?>').on('click', function(){
                                        bootbox.confirm("Are you sure you want to delete this post?", function(result) {
                                            $.post("includes/form_handlers/delete_forum_post.php?forum_post_id=<?php echo $id; ?>",
                                                {result:result});
                                            if(result)
                                                location.reload();

                                        });

                                    });

                                    $('#move_forum_post<?php echo $id; ?>').on('click', function(){
                                            bootbox.confirm("Are you sure you want to move this post to front page?", function(result) {
                                                $.post("includes/form_handlers/move_forum_post.php?move_forum_post_id=<?php echo $id; ?>",
                                                    {result:result});
                                                if(result)
                                                    location.reload();

                                            });

                                        });

                                });



                            </script>



                            <?php
                }
                }
        }

        echo $str;
    }

    public function loadTopicJokes() {

      $userLoggedIn = $this->user_obj->getUsername();
        define("admin", "abigail_oba");

      $str = " "; //string to return

      if(isset($_GET['page'])) {
        $page = $_GET['page'];
        if($page == 0 || $page<1 ) {
              $showPostFrom = 0;
          }else {
              $showPostFrom = ($page * 30) - 30;
          }

        $data_query = mysqli_query($this->con, "SELECT * FROM forum_topics WHERE category='jokes' ORDER BY id DESC LIMIT $showPostFrom, 30");
        $count = mysqli_num_rows($data_query);
        $PostsPerPage = $count/30;
        $PostsPerPage = ceil($PostsPerPage);
        if(mysqli_num_rows($data_query) > 0) {

            $num_iterations = 0; //Number of results checked (not necessarily posted)
            $count = 1;

            while($row = mysqli_fetch_array($data_query)) {
                $id = $row['id'];
                $post = $row['post'];
                $title = $row['title'];
                $category = $row['category'];
                $added_by = $row['posted_by'];
                $date_time = $row['date_posted'];
                $imagePath = $row['image_attachment'];
                $likes = $row['likes'];


                    if($userLoggedIn == $added_by || $userLoggedIn == admin)
                            $delete_button = "<button class='delete_button btn-danger' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='forum_post$id'>x</button>";
                        else
                            $delete_button = "";

                        if($userLoggedIn == admin)
                            $move_button = "<button class='move_button btn-success' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='move_forum_post$id'>m</button>";
                        else
                            $move_button = "";

                    $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
                    $user_row = mysqli_fetch_array($user_details_query);
                    $first_name = $user_row['first_name'];
                    $last_name = $user_row['last_name'];
                    $profile_pic = $user_row['profile_pic'];

                    ?>
                    <script>
                        function toggle<?php echo $id; ?>() {

                            var target = $(event.target);
                            if(!target.is("a")) {

                                var element = document.getElementById("toggleComment<?php echo $id; ?>");
                                if(element.style.display == "block")
                                    element.style.display = "none";
                                else
                                    element.style.display = "block";
                                }
                            }


                    </script>


                    <?php

                    $comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE forum_post_id='$id'");
                    $comments_check_num = mysqli_num_rows($comments_check);

                    //Timeframe
                    $date_time_now = date("Y-m-d H:i:s");
                    $start_date = new DateTime($date_time); //Time of post
                    $end_date = new DateTime($date_time_now); //Current time
                    $interval = $start_date->diff($end_date); //Difference between dates
                    if($interval->y >= 1) {
                        if($interval == 1)
                            $time_message = $interval->y." year ago"; //1 year ago
                        else
                            $time_message = $interval->y." years ago"; //1 year ago

                    }
                    else if($interval->m >= 1) {
                        if($interval->d == 0) {
                            $days = " ago";
                        }
                        else if($interval->d == 1) {
                            $days = $interval->d . " day ago";
                        }
                        else {
                            $days = $interval->d . " days ago";
                        }

                        if($interval->m == 1) {
                            $time_message = $interval->m . " month".$days;
                        }
                        else {
                            $time_message = $interval->m . " months".$days;
                        }
                    }

                    else if($interval->d >= 1) {
                        if($interval->d == 1) {
                            $time_message = "Yesterday";
                        }
                        else {
                            $time_message = $interval->d . " days ago";
                        }
                    }
                    else if($interval->h >= 1) {
                        if($interval->h == 1) {
                            $time_message = $interval->h . " hour ago";
                        }
                        else {
                            $time_message = $interval->h . " hours ago";
                        }
                    }

                    else if($interval->i >= 1) {
                        if($interval->i == 1) {
                            $time_message = $interval->i . " minute ago";
                        }
                        else {
                            $time_message = $interval->i . " minutes ago";
                        }
                    }

                    else {
                        if($interval->s < 30) {
                            $time_message = "Just now";
                        }
                        else {
                            $time_message = $interval->s . " seconds ago";
                        }
                    }

                    if($imagePath != "") {
                        $imageDiv = "<div class='postedImage'>
                                        <img src='$imagePath'>
                                    </div>";
                    }
                    else {
                        $imageDiv = "";
                    }

                    $str .= "<div class='forum_post' style='color:#ACACAC; border: 1px #D3D3D3 solid; padding:10px; text-align:center;'>


                                    <img src='$profile_pic' style='width:30px; height:30px; border-radius:15px;'><a href='post_details.php?forum_post_id=$id&page=1'><b> &laquo; $title &raquo; </b></a>
                                    <br><small style='font-size:11px;'>Posted by: $added_by &nbsp; $time_message &nbsp;&nbsp; Comments($comments_check_num) &nbsp;$delete_button&nbsp;&nbsp;$move_button</small>


                            </div>";

                            ?>
                            <script type="text/javascript">
                                $(document).ready(function() {

                                    $('#forum_post<?php echo $id; ?>').on('click', function(){
                                        bootbox.confirm("Are you sure you want to delete this post?", function(result) {
                                            $.post("includes/form_handlers/delete_forum_post.php?forum_post_id=<?php echo $id; ?>",
                                                {result:result});
                                            if(result)
                                                location.reload();

                                        });

                                    });

                                    $('#move_forum_post<?php echo $id; ?>').on('click', function(){
                                        bootbox.confirm("Are you sure you want to move this post to front page?", function(result) {
                                            $.post("includes/form_handlers/move_forum_post.php?move_forum_post_id=<?php echo $id; ?>",
                                                {result:result});
                                            if(result)
                                                location.reload();

                                        });

                                    });

                                });



                            </script>



                            <?php
                }
                }
        }

        echo $str;
    }

    public function loadTopicSports() {

      $userLoggedIn = $this->user_obj->getUsername();
        define("admin", "abigail_oba");

      $str = " "; //string to return

      if(isset($_GET['page'])) {
        $page = $_GET['page'];
        if($page == 0 || $page<1 ) {
              $showPostFrom = 0;
          }else {
              $showPostFrom = ($page * 30) - 30;
          }

        $data_query = mysqli_query($this->con, "SELECT * FROM forum_topics WHERE category='sports' ORDER BY id DESC LIMIT $showPostFrom, 30");
        $count = mysqli_num_rows($data_query);
        $PostsPerPage = $count/30;
        $PostsPerPage = ceil($PostsPerPage);
        if(mysqli_num_rows($data_query) > 0) {

            $num_iterations = 0; //Number of results checked (not necessarily posted)
            $count = 1;

            while($row = mysqli_fetch_array($data_query)) {
                $id = $row['id'];
                $post = $row['post'];
                $title = $row['title'];
                $category = $row['category'];
                $added_by = $row['posted_by'];
                $date_time = $row['date_posted'];
                $imagePath = $row['image_attachment'];
                $likes = $row['likes'];


                    if($userLoggedIn == $added_by || $userLoggedIn == admin)
                            $delete_button = "<button class='delete_button btn-danger' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='forum_post$id'>x</button>";
                        else
                            $delete_button = "";

                        if($userLoggedIn == admin)
                            $move_button = "<button class='move_button btn-success' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='move_forum_post$id'>m</button>";
                        else
                            $move_button = "";

                    $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
                    $user_row = mysqli_fetch_array($user_details_query);
                    $first_name = $user_row['first_name'];
                    $last_name = $user_row['last_name'];
                    $profile_pic = $user_row['profile_pic'];

                    ?>
                    <script>
                        function toggle<?php echo $id; ?>() {

                            var target = $(event.target);
                            if(!target.is("a")) {

                                var element = document.getElementById("toggleComment<?php echo $id; ?>");
                                if(element.style.display == "block")
                                    element.style.display = "none";
                                else
                                    element.style.display = "block";
                                }
                            }


                    </script>


                    <?php

                    $comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE forum_post_id='$id'");
                    $comments_check_num = mysqli_num_rows($comments_check);

                    //Timeframe
                    $date_time_now = date("Y-m-d H:i:s");
                    $start_date = new DateTime($date_time); //Time of post
                    $end_date = new DateTime($date_time_now); //Current time
                    $interval = $start_date->diff($end_date); //Difference between dates
                    if($interval->y >= 1) {
                        if($interval == 1)
                            $time_message = $interval->y." year ago"; //1 year ago
                        else
                            $time_message = $interval->y." years ago"; //1 year ago

                    }
                    else if($interval->m >= 1) {
                        if($interval->d == 0) {
                            $days = " ago";
                        }
                        else if($interval->d == 1) {
                            $days = $interval->d . " day ago";
                        }
                        else {
                            $days = $interval->d . " days ago";
                        }

                        if($interval->m == 1) {
                            $time_message = $interval->m . " month".$days;
                        }
                        else {
                            $time_message = $interval->m . " months".$days;
                        }
                    }

                    else if($interval->d >= 1) {
                        if($interval->d == 1) {
                            $time_message = "Yesterday";
                        }
                        else {
                            $time_message = $interval->d . " days ago";
                        }
                    }
                    else if($interval->h >= 1) {
                        if($interval->h == 1) {
                            $time_message = $interval->h . " hour ago";
                        }
                        else {
                            $time_message = $interval->h . " hours ago";
                        }
                    }

                    else if($interval->i >= 1) {
                        if($interval->i == 1) {
                            $time_message = $interval->i . " minute ago";
                        }
                        else {
                            $time_message = $interval->i . " minutes ago";
                        }
                    }

                    else {
                        if($interval->s < 30) {
                            $time_message = "Just now";
                        }
                        else {
                            $time_message = $interval->s . " seconds ago";
                        }
                    }

                    if($imagePath != "") {
                        $imageDiv = "<div class='postedImage'>
                                        <img src='$imagePath'>
                                    </div>";
                    }
                    else {
                        $imageDiv = "";
                    }

                    $str .= "<div class='forum_post' style='color:#ACACAC; border: 1px #D3D3D3 solid; padding:10px; text-align:center;'>


                                    <img src='$profile_pic' style='width:30px; height:30px; border-radius:15px;'><a href='post_details.php?forum_post_id=$id&page=1'><b> &laquo; $title &raquo; </b></a>
                                    <br><small style='font-size:11px;'>Posted by: $added_by &nbsp; $time_message &nbsp;&nbsp; Comments($comments_check_num) &nbsp;$delete_button&nbsp;&nbsp;$move_button</small>


                            </div>";

                            ?>
                            <script type="text/javascript">
                                $(document).ready(function() {

                                    $('#forum_post<?php echo $id; ?>').on('click', function(){
                                        bootbox.confirm("Are you sure you want to delete this post?", function(result) {
                                            $.post("includes/form_handlers/delete_forum_post.php?forum_post_id=<?php echo $id; ?>",
                                                {result:result});
                                            if(result)
                                                location.reload();

                                        });

                                    });

                                      $('#move_forum_post<?php echo $id; ?>').on('click', function(){
                                            bootbox.confirm("Are you sure you want to move this post to front page?", function(result) {
                                                $.post("includes/form_handlers/move_forum_post.php?move_forum_post_id=<?php echo $id; ?>",
                                                    {result:result});
                                                if(result)
                                                    location.reload();

                                            });

                                        });

                                });



                            </script>



                            <?php
                }
                }
        }

        echo $str;
    }

    public function loadTopicMarketPlace() {

      $userLoggedIn = $this->user_obj->getUsername();
        define("admin", "abigail_oba");

      $str = " "; //string to return

      if(isset($_GET['page'])) {
        $page = $_GET['page'];
        if($page == 0 || $page<1 ) {
              $showPostFrom = 0;
          }else {
              $showPostFrom = ($page * 30) - 30;
          }

        $data_query = mysqli_query($this->con, "SELECT * FROM forum_topics WHERE category='marketplace' ORDER BY id DESC LIMIT $showPostFrom, 30");
        $count = mysqli_num_rows($data_query);
        $PostsPerPage = $count/30;
        $PostsPerPage = ceil($PostsPerPage);
        if(mysqli_num_rows($data_query) > 0) {

            $num_iterations = 0; //Number of results checked (not necessarily posted)
            $count = 1;

            while($row = mysqli_fetch_array($data_query)) {
                $id = $row['id'];
                $post = $row['post'];
                $title = $row['title'];
                $category = $row['category'];
                $added_by = $row['posted_by'];
                $date_time = $row['date_posted'];
                $imagePath = $row['image_attachment'];
                $likes = $row['likes'];


                    if($userLoggedIn == $added_by || $userLoggedIn == admin)
                            $delete_button = "<button class='delete_button btn-danger' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='forum_post$id'>x</button>";
                        else
                            $delete_button = "";

                        if($userLoggedIn == admin)
                            $move_button = "<button class='move_button btn-success' style='float: right; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='move_forum_post$id'>m</button>";
                        else
                            $move_button = "";

                    $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
                    $user_row = mysqli_fetch_array($user_details_query);
                    $first_name = $user_row['first_name'];
                    $last_name = $user_row['last_name'];
                    $profile_pic = $user_row['profile_pic'];

                    ?>
                    <script>
                        function toggle<?php echo $id; ?>() {

                            var target = $(event.target);
                            if(!target.is("a")) {

                                var element = document.getElementById("toggleComment<?php echo $id; ?>");
                                if(element.style.display == "block")
                                    element.style.display = "none";
                                else
                                    element.style.display = "block";
                                }
                            }


                    </script>


                    <?php

                    $comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE forum_post_id='$id'");
                    $comments_check_num = mysqli_num_rows($comments_check);

                    //Timeframe
                    $date_time_now = date("Y-m-d H:i:s");
                    $start_date = new DateTime($date_time); //Time of post
                    $end_date = new DateTime($date_time_now); //Current time
                    $interval = $start_date->diff($end_date); //Difference between dates
                    if($interval->y >= 1) {
                        if($interval == 1)
                            $time_message = $interval->y." year ago"; //1 year ago
                        else
                            $time_message = $interval->y." years ago"; //1 year ago

                    }
                    else if($interval->m >= 1) {
                        if($interval->d == 0) {
                            $days = " ago";
                        }
                        else if($interval->d == 1) {
                            $days = $interval->d . " day ago";
                        }
                        else {
                            $days = $interval->d . " days ago";
                        }

                        if($interval->m == 1) {
                            $time_message = $interval->m . " month".$days;
                        }
                        else {
                            $time_message = $interval->m . " months".$days;
                        }
                    }

                    else if($interval->d >= 1) {
                        if($interval->d == 1) {
                            $time_message = "Yesterday";
                        }
                        else {
                            $time_message = $interval->d . " days ago";
                        }
                    }
                    else if($interval->h >= 1) {
                        if($interval->h == 1) {
                            $time_message = $interval->h . " hour ago";
                        }
                        else {
                            $time_message = $interval->h . " hours ago";
                        }
                    }

                    else if($interval->i >= 1) {
                        if($interval->i == 1) {
                            $time_message = $interval->i . " minute ago";
                        }
                        else {
                            $time_message = $interval->i . " minutes ago";
                        }
                    }

                    else {
                        if($interval->s < 30) {
                            $time_message = "Just now";
                        }
                        else {
                            $time_message = $interval->s . " seconds ago";
                        }
                    }

                    if($imagePath != "") {
                        $imageDiv = "<div class='postedImage'>
                                        <img src='$imagePath'>
                                    </div>";
                    }
                    else {
                        $imageDiv = "";
                    }

                    $str .= "<div class='forum_post' style='color:#ACACAC; border: 1px #D3D3D3 solid; padding:10px; text-align:center;'>


                                    <img src='$profile_pic' style='width:30px; height:30px; border-radius:15px;'><a href='post_details.php?forum_post_id=$id&page=1'><b> &laquo; $title &raquo; </b></a>
                                    <br><small style='font-size:11px;'>Posted by: $added_by &nbsp; $time_message &nbsp;&nbsp; Comments($comments_check_num) &nbsp;$delete_button&nbsp;&nbsp;$move_button</small>


                            </div>";

                            ?>
                            <script type="text/javascript">
                                $(document).ready(function() {

                                    $('#forum_post<?php echo $id; ?>').on('click', function(){
                                        bootbox.confirm("Are you sure you want to delete this post?", function(result) {
                                            $.post("includes/form_handlers/delete_forum_post.php?forum_post_id=<?php echo $id; ?>",
                                                {result:result});
                                            if(result)
                                                location.reload();

                                        });

                                    });

                                    $('#move_forum_post<?php echo $id; ?>').on('click', function(){
                                        bootbox.confirm("Are you sure you want to move this post to front page?", function(result) {
                                            $.post("includes/form_handlers/move_forum_post.php?move_forum_post_id=<?php echo $id; ?>",
                                                {result:result});
                                            if(result)
                                                location.reload();

                                        });

                                    });


                                });



                            </script>



                            <?php
                }
                }
        }

        echo $str;
    }

    public function loadTopicHomepage() {

        define("admin", "abigail_oba");
        $userLoggedIn = $this->user_obj->getUsername();

        $str = " "; //string to return

        if(isset($_GET['page'])) {
          $page = $_GET['page'];
          if($page == 0 || $page<1 ) {
                $showPostFrom = 0;
            }else {
                $showPostFrom = ($page * 30) - 30;
            }

          $data_query = mysqli_query($this->con, "SELECT * FROM forum_homepage ORDER BY id DESC LIMIT $showPostFrom, 30");
          $count = mysqli_num_rows($data_query);
          $PostsPerPage = $count/30;
          $PostsPerPage = ceil($PostsPerPage);

            if(mysqli_num_rows($data_query) > 0) {

                $num_iterations = 0; //Number of results checked (not necessarily posted)
                $count = 1;

                while($row = mysqli_fetch_array($data_query)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $added_by = $row['added_by'];
                    $date_time = $row['date_added'];
                    $forum_post_id = $row['forum_post_id'];




                        if($userLoggedIn == $added_by || $userLoggedIn == admin)
                            $delete_button = "<button class='delete_button btn-danger' style='right: none; background-color:#D3D3D3; border-radius:50%; text-align:center;' id='forum_post$id'>x</button>";
                        else
                            $delete_button = "";



                        $user_details_query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$added_by'");
                        $user_row = mysqli_fetch_array($user_details_query);
                        $first_name = $user_row['first_name'];
                        $last_name = $user_row['last_name'];
                        $profile_pic = $user_row['profile_pic'];


                        $comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE forum_post_id='$forum_post_id'");
                        $comments_check_num = mysqli_num_rows($comments_check);

                        //Timeframe
                        $date_time_now = date("Y-m-d H:i:s");
                        $start_date = new DateTime($date_time); //Time of post
                        $end_date = new DateTime($date_time_now); //Current time
                        $interval = $start_date->diff($end_date); //Difference between dates
                        if($interval->y >= 1) {
                            if($interval == 1)
                                $time_message = $interval->y." year ago"; //1 year ago
                            else
                                $time_message = $interval->y." years ago"; //1 year ago

                        }
                        else if($interval->m >= 1) {
                            if($interval->d == 0) {
                                $days = " ago";
                            }
                            else if($interval->d == 1) {
                                $days = $interval->d . " day ago";
                            }
                            else {
                                $days = $interval->d . " days ago";
                            }

                            if($interval->m == 1) {
                                $time_message = $interval->m . " month".$days;
                            }
                            else {
                                $time_message = $interval->m . " months".$days;
                            }
                        }

                        else if($interval->d >= 1) {
                            if($interval->d == 1) {
                                $time_message = "Yesterday";
                            }
                            else {
                                $time_message = $interval->d . " days ago";
                            }
                        }
                        else if($interval->h >= 1) {
                            if($interval->h == 1) {
                                $time_message = $interval->h . " hour ago";
                            }
                            else {
                                $time_message = $interval->h . " hours ago";
                            }
                        }

                        else if($interval->i >= 1) {
                            if($interval->i == 1) {
                                $time_message = $interval->i . " minute ago";
                            }
                            else {
                                $time_message = $interval->i . " minutes ago";
                            }
                        }

                        else {
                            if($interval->s < 30) {
                                $time_message = "Just now";
                            }
                            else {
                                $time_message = $interval->s . " seconds ago";
                            }
                        }



                        $str .= "<div class='forum_post' style='color:#ACACAC; border: 1px #D3D3D3 solid; padding:10px; text-align:center;'>


                                        <img src='$profile_pic' style='width:30px; height:30px; border-radius:15px;'><a href='post_details.php?forum_post_id=$forum_post_id&page=1'><b> &laquo; $title &raquo; </b></a>
                                        <br><small style='font-size:11px;'>Posted by: $added_by &nbsp; $time_message &nbsp;&nbsp; Comments($comments_check_num) &nbsp;$delete_button</small>


                                </div>";

                    ?>
                    <script type="text/javascript">
                        $(document).ready(function() {

                            $('#forum_post<?php echo $id; ?>').on('click', function(){
                                bootbox.confirm("Are you sure you want to delete this post?", function(result) {
                                    $.post("includes/form_handlers/delete_forum_post.php?forum_post_id=<?php echo $id; ?>",
                                        {result:result});
                                    if(result)
                                        location.reload();

                                });

                            });


                        });



                    </script>



                    <?php
                    }
                  }

        }

        echo $str;
    }




    public function loadPostDetails() {
        define("admin", "abigail_oba");
      $str = " ";
      if(isset($_GET['forum_post_id']) && (isset($_GET['page']))) {


            $forum_post_id = $_GET['forum_post_id'];
            $page = $_GET['page'];


            if($page == 0 || $page<1 ) {
                $showPostFrom = 0;
            }else {
                $showPostFrom = ($page * 20) - 20;
            }


            $userLoggedIn = $this->user_obj->getUsername();

            $comments="";

            $user_query = mysqli_query($this->con, "SELECT * FROM forum_topics WHERE id='$forum_post_id'");
            $row = mysqli_fetch_array($user_query);

            $category = $row['category'];
            $posted_by = $row['posted_by'];
            $date_posted = $row['date_posted'];
            $likes = $row['likes'];
            $image = $row['image_attachment'];
            $post_body = nl2br($row['post']);
            $title = $row['title'];

            if($userLoggedIn == $posted_by || $userLoggedIn == admin)
                $delete_button = "<button class='delete_button btn-danger' style='float: right; '>x</button>";
            else
                $delete_button = "";

            if($userLoggedIn == $posted_by)
                $edit = "<small style='color:#20AAE5;'>Edit</small>";
            else
                $edit = "";

            $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$posted_by'");
            $user_row = mysqli_fetch_array($user_details_query);
            $first_name = $user_row['first_name'];
            $last_name = $user_row['last_name'];
            $profile_pic = $user_row['profile_pic'];

            $comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE forum_post_id='$forum_post_id'");
            $comments_check_num = mysqli_num_rows($comments_check);




            //Timeframe
            $date_time_now = date("Y-m-d H:i:s");
            $start_date = new DateTime($date_posted); //Time of post
            $end_date = new DateTime($date_time_now); //Current time
            $interval = $start_date->diff($end_date); //Difference between dates
            if($interval->y >= 1) {
                if($interval == 1)
                    $time_message = $interval->y." year ago"; //1 year ago
                else
                    $time_message = $interval->y." years ago"; //1 year ago

            }
            else if($interval->m >= 1) {
                if($interval->d == 0) {
                    $days = " ago";
                }
                else if($interval->d == 1) {
                    $days = $interval->d . " day ago";
                }
                else {
                    $days = $interval->d . " days ago";
                }

                if($interval->m == 1) {
                    $time_message = $interval->m . " month".$days;
                }
                else {
                    $time_message = $interval->m . " months".$days;
                }
            }

            else if($interval->d >= 1) {
                if($interval->d == 1) {
                    $time_message = "Yesterday";
                }
                else {
                    $time_message = $interval->d . " days ago";
                }
            }
            else if($interval->h >= 1) {
                if($interval->h == 1) {
                    $time_message = $interval->h . " hour ago";
                }
                else {
                    $time_message = $interval->h . " hours ago";
                }
            }

            else if($interval->i >= 1) {
                if($interval->i == 1) {
                    $time_message = $interval->i . " minute ago";
                }
                else {
                    $time_message = $interval->i . " minutes ago";
                }
            }

            else {
                if($interval->s < 30) {
                    $time_message = "Just now";
                }
                else {
                    $time_message = $interval->s . " seconds ago";
                }
            }

            if($image != "") {
                $imageDiv = "<div class='postedImage'>
                                <img src='$image' style='img-responsive'>
                            </div>";
            }
            else {
                $imageDiv = "";
            }




            $get_forum_comments = mysqli_query($this->con, "SELECT * FROM comments WHERE forum_post_id='$forum_post_id' ORDER BY id ASC LIMIT $showPostFrom, 20");
            $count = mysqli_num_rows($get_forum_comments);
            $commentsPerPage = $count/20;
            $commentsPerPage = ceil($commentsPerPage);



            if($count != 0) {

                 while($comment = mysqli_fetch_array($get_forum_comments)) {

                     $comment_body = nl2br($comment['post_body']);
                     $forum_comment_id = $comment['id'];
                     $posted_to = $comment['posted_to'];
                     $commented_by = $comment['posted_by'];
                     $date_added = $comment['date_added'];
                     $removed = $comment['removed'];

                     $comment_date_time_now = date("Y-m-d H:i:s");
                     $comment_start_date = new DateTime($date_added); //Time of post
                     $comment_end_date = new DateTime($comment_date_time_now); //Current time
                     $comment_interval = $comment_start_date->diff($comment_end_date); //Difference between dates
                     if($comment_interval->y >= 1) {
                         if($comment_interval == 1)
                             $comment_time_message = $comment_interval->y." year ago"; //1 year ago
                         else
                             $comment_time_message = $comment_interval->y." years ago"; //1 year ago

                     }
                     else if($comment_interval->m >= 1) {
                         if($comment_interval->d == 0) {
                             $days = " ago";
                         }
                         else if($comment_interval->d == 1) {
                             $days = $comment_interval->d . " day ago";
                         }
                         else {
                             $days = $comment_interval->d . " days ago";
                         }

                         if($comment_interval->m == 1) {
                             $comment_time_message = $comment_interval->m . " month".$days;
                         }
                         else {
                             $comment_time_message = $comment_interval->m . " months".$days;
                         }
                     }

                     else if($comment_interval->d >= 1) {
                         if($comment_interval->d == 1) {
                             $comment_time_message = "Yesterday";
                         }
                         else {
                             $comment_time_message = $comment_interval->d . " days ago";
                         }
                     }
                     else if($comment_interval->h >= 1) {
                         if($comment_interval->h == 1) {
                             $comment_time_message = $comment_interval->h . " hour ago";
                         }
                         else {
                             $comment_time_message = $comment_interval->h . " hours ago";
                         }
                     }

                     else if($comment_interval->i >= 1) {
                         if($comment_interval->i == 1) {
                             $comment_time_message = $comment_interval->i . " minute ago";
                         }
                         else {
                             $comment_time_message = $comment_interval->i . " minutes ago";
                         }
                     }

                     else {
                         if($comment_interval->s < 30) {
                             $comment_time_message = "Just now";
                         }
                         else {
                             $comment_time_message = $comment_interval->s . " seconds ago";
                         }
                     }

                     if($userLoggedIn == $commented_by)
                         $edit_comment = "<small style='color:#20AAE5;'>Edit</small>";
                     else
                         $edit_comment = "";

                     $comments .= "<div class='comment_thread' style='height: auto; width: inherit; color:#20AAE5; border: 1px solid grey; border-radius: 9px; padding:10px;'>
                                      <div><b>Re: $title</b>&nbsp;&nbsp; <small style='color:#ACACAC; font-size:11px;'>Comment by: $commented_by &nbsp;$comment_time_message</small></div><hr>
                                      <div style='color:grey;'>$comment_body</div><hr>
                                      <div class='newsfeedPostOptions' style='padding:0px 5px 0px 10px;'>
                                                <a href='comment_forum_quote.php?forum_comment_id=$forum_comment_id&forum_post_id=$forum_post_id'><small>Quote</small></a>
                                                <iframe src='like.php?forum_comment_id=$forum_comment_id' style='height:15px;' scrolling='no'></iframe><a href='comment_forum_comment_edit.php?forum_comment_id=$forum_comment_id&forum_post_id=$forum_post_id'>$edit_comment</a>&nbsp;&nbsp;
                                      </div>
                                  </div>";
               }
            }


            $str .= "<div class='detail_forum_post'>

                        <div class='post_title' style='color:#ACACAC; background-color:#D3D3D3; border: 1px solid grey; padding:5px 10px 5px 10px;'>
                            <div style='position: relative;'><img src='$profile_pic' style='width:30px; height:30px; border-radius:15px;'><a href='post_details.php?forum_post_id=$forum_post_id'><b> $title </b></a>
                            <small style='font-size:11px;'>Posted by: $posted_by &nbsp; $time_message</small></div>
                        </div>
                        <div class='post_body_div' style='color:grey; background-color:#fff; padding:10px 10px 2px 10px; border: 1px solid grey; border-bottom-right-radius: 9px; border-bottom-left-radius: 9px;'>
                            $post_body <br>
                            $imageDiv<hr>
                            <div class='newsfeedPostOptions' style='padding:0px 5px 0px 5px;'>
                                      Comments($comments_check_num)&nbsp;&nbsp;&nbsp;<a href='comment_forum.php?forum_post_id=$forum_post_id'><small>Reply</small></a>&nbsp;&nbsp;
                                      <iframe src='like.php?forum_post_id=$forum_post_id' style='height:15px;' scrolling='no'></iframe><a href='comment_forum_post_edit.php?forum_post_id=$forum_post_id'>$edit</a>
                            </div><iframe src='https://www.facebook.com/plugins/share_button.php?href=http%3A%2F%2Flocalhost%3A1234%2Fphpcourse%2Findex.php&layout=button_count&size=small&mobile_iframe=true&width=69&height=20&appId' width='69' height='20' style='border:none;overflow:hidden' scrolling='no' frameborder='0' allowTransparency='true' allow='encrypted-media'></iframe>
                        </div>

                        <div class='comment_forum_div' style='background-color:#fff;'>$comments</div><br>

                        <div></div>
                    </div>";
                  }

                echo $str;


        }


}

?>
