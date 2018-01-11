<?php
    // manager de la classe post
    class PostManager
    {
        public function insert(Post $post)
        {
            $query = $db->prepare('INSERT INTO Post (title, dateTimePub, dateTimeExp, content) VALUES (:title, :dateTimePub, :dateTimeExp, :content)');
            $query->bindValue(':title', $post->getTitle());
            $query->bindValue(':dateTimePub', $post->getDateTimePub());
            $query->bindValue(':dateTimeExp', $post->getDateTimeExp());
            $query->bindValue(':content', $post->getContent());
            
            $query->execute();
        }
        
        //DATE_FORMAT(dateTimePub, \'%m/%c/%Y à %H:%i:%s\') AS DHP, DATE_FORMAT(dateTimeExp, \'%m/%c/%Y à %H:%i:%s\') AS DHE
        
        public function getOnePost($title)
        {
            $query = $db->query('SELECT title, dateTimePub, dateTimeExp, content FROM Post WHERE title = "' . $title . '"');
            return new Post($query->fetch(PDO::FETCH_ASSOC));
        }
        
        public function getAllPostsExceptExpiry()
        {
            $allPosts = [];
            $query = $db->query('SELECT title, dateTimePub, dateTimeExp, content FROM Post ORDER BY dateTimePub');
            while($onePostFromSQL = $query->fetch(PDO::FETCH_ASSOC))
            {
                $post = new Post($onePostFromSQL);
                if (date('d/m/Y H:i:s') < $post->getDateTimeExp() || $post->getDateTimeExp() == NULL)
                    $allPosts[] = $post;
            }
            return $allPosts;
        }
        
        public function modify(Post $post)
        {
            $query = $db->prepare('UPDATE Post SET title = :title, dateTimePub = :dateTimePub, dateTimeExp = :dateTimeExp, content = :content WHERE title = :title');

            $query->bindValue(':title', $post->getTitle());
            $query->bindValue(':dateTimePub', $post->getDateTimePub());
            $query->bindValue(':dateTimeExp', $post->getDateTimeExp());
            $query->bindValue(':content', $post->getContent());
            
            $query->execute();
        }
        
        public function delete($title)
        {
            $db->exec('DELETE FROM Post WHERE title = "' . $title . '"');
        }
    }

    //classe allPosts = articles postés, morceaux de livre
    class Post
    {
        // attributs
        private $_title;
        private $_dateTimePub;
        private $_dateTimeExp;
        private $_content;

        // const DEBUT_TITRES = "title : "; // juste pour l'entrainement

        // private static $_total = 0; // juste pour l'entrainement

        // constructeur
        public function __construct()
        {
            $numberOfArgs = func_num_args();
            $args = func_get_args();
            $counter = 0;
            $setters = array("setTitle", "setDateTimePub", "setDateTimeExp", "setContent");
            if (is_array($args[0]) && $numberOfArgs == 1)
                $this->hydrate($args[0]);
            else
                while ($counter < $numberOfArgs && $counter < count($setters))
                {
                    $this->$setters[$counter]($args[$counter]);
                    $counter++;
                }
        }
        
        public function hydrate (array $onePostFromSQL)
        {
            foreach($onePostFromSQL as $key => $value)
            {
                $method = 'set' . ucfirst($key);
                if (method_exists($this, $method))
                    $this->$method($value);
            }
        }

        // accesseurs
        public function getTitle()
        {
            return $this->_title;
        }
        public function getDateTimePub()
        {
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $this->_dateTimePub);
            $date = $date->format('d/m/Y H:i:s');
            return $date;
        }
        public function getDateTimeExp()
        {
            $date = $this->_dateTimeExp;
            if ($this->_dateTimeExp != NULL)
            {
                $date = DateTime::createFromFormat('Y-m-d H:i:s', $this->_dateTimeExp);
                $date = $date->format('d/m/Y H:i:s');
            }
            return $date;
        }
        public function getContent()
        {
            return $this->_content;
        }

        // mutateurs
        public function setTitle($title)
        {
            // verification type
            if (! is_string($title))
            {
                trigger_error('le title du post n\'a pu être modifié, le paramètre n\'est pas une chaîne de caractères.', E_USER_WARNING);
                return;
            }
            // verification taille
            if (strlen($title) > 120)
            {
                trigger_error('le title du post n\'a pu être modifié, le paramètre étant une chaîne de caractères trop longue.', E_USER_WARNING);
                return;
            }

            $this->_title = $title; // juste pour m'entrainer avec self:: etc
        }
        
        public function setDateTimePub($dateTimePub) // là force a prendre un stirng
        {
            // try essayer de caster en dateTimePub
            $this->_dateTimePub = $dateTimePub;
        }
        
        public function setDateTimeExp($dateTimeExp)
        {
            $this->_dateTimeExp = $dateTimeExp;
        }

        public function setContent($content)
        {
            if (! is_string($content))
            {
                trigger_error('le content du post n\'a pu être modifié, le paramètre n\'est pas une chaîne de caractères.', E_USER_WARNING);
            }
            else
                $this->_content = $content;
        }
    }