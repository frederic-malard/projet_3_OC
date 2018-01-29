<?php
    require_once('model/Post.php');
    require_once('model/Comment.php');
    require_once('model/User.php');
?>

<?php
    class AdminControler
    {
        private $_adminPostManager;
        private $_adminCommentManager;
        
        public function __construct()
        {
            $this->_adminPostManager = new PostManager();
            $this->_adminCommentManager = new CommentManager();
        }
        
        public function postsManagment()
        {
            try
            {
                // préparation des variables
                $pageTitle = 'gestion des billets';
                if (! isset($_GET['page']))
                    $_GET['page'] = 1;
                $indiceBegining = 5 * ((int) strip_tags($_GET['page']) - 1);
                $postsPerPages = 5;
                $indexPost = $indiceBegining;
                $postsLeft = $postsPerPages;
                $allPosts = $this->_adminPostManager->getAllPostsExceptExpiry();
                $cssClass = array('postsManagment' => 'greyButton', 'commentsReported' => '', 'createPost' => ''); // the postsManagment button will be grey
                
                // récupération de la vue, et envoie de cette dernière au template
                ob_start();
                require_once $_SERVER['DOCUMENT_ROOT'] . '/view/adminHeaderMenuView.php';
                require_once $_SERVER['DOCUMENT_ROOT'] . '/view/postsManagmentView.php';
                $content = ob_get_clean();
                require_once $_SERVER['DOCUMENT_ROOT'] . '/view/template.php';
            }
            catch (Exception $e)
            {
                echo '<p>erreur : ' . $e->getMessage() ; '</p>';
            }
        }
        public function commentsReported()
        {
            $pageTitle = 'commentaires signalés';
            ob_start();
            require_once $_SERVER['DOVUMENT_ROOT'] . '/view/adminHeaderMenuView.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/commentsReportedView.php';
            $content = ob_get_clean();
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/template.php';
        }
        public function createPost()
        {
            $pageTitle = 'créer un nouveau billet';
            ob_start();
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/adminHeaderMenuView.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/createPostView.php';
            $content = ob_get_clean();
            require_once $_SERVER['DOCUMENT_ROOT'] . '/view/template.php';
        }
    }

/*
a caler ailleurs :
    <textarea class="tinymce"></textarea>
    <script type="text/javascript" src="../plugins/jquery.min.js"></script>
    <script type="text/javascript" src="../plugins/tinymce/tinymce.min.js"></script>
    <script type="text/javascript" src="../plugins/tinymce/init-tinymce.js"></script>
*/