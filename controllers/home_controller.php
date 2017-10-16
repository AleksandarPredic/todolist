<?php

namespace TodoList\Controllers;

use TodoList\Libs\Controller;

/**
 * Class Home_Controller - responsible for items CRUD control
 * @package TodoList\Controllers
 */
class Home_Controller extends Controller {

    public function __construct($name = '') {
        parent::__construct($name);

        // Require authentication
        $this->authUserMiddleware();

    }

    /**
     * List all items with pagination
     */
    public function index() {

        $this->itemsPerPage = 3;
        $this->itemsCount = $this->model->countItems();
        $this->view->nonce = $this->createNonce();

        if ($this->itemsCount <= $this->itemsPerPage) {

            $this->listAll();
        } else {
            $this->paginate();
        }
    }

    /**
     * Create item view form
     */
    public function create() {

        $this->view->title = isset( $_SESSION['form_fields']['title'] ) ? $_SESSION['form_fields']['title'] : '';
        $this->view->text = isset( $_SESSION['form_fields']['text'] ) ? $_SESSION['form_fields']['text'] : '';
        $this->view->nonce = $this->createNonce();
        $this->view->render('home/create.php');
        unset($_SESSION['form_fields']);

    }

    /**
     * Save item via $_POST
     */
    public function store() {

        // Server side validate
        if (
            ! isset( $_POST['create_item'] )
            || ( ! isset( $_POST['title'] ) || empty( $_POST['title'] ) )
            || ( ! isset( $_POST['text'] ) || empty( $_POST['text'] ) )
        ) {
            $this->setOldFormValues(array( 'title' => $_POST['title'], 'text' => $_POST['text'] ));
            $this->redirect('home/create', 'False form data sent or empty fields!');
        }

        // Check nonce
        if ( !isset( $_POST['nonce'] ) || ! $this->checkNonce( $_POST['nonce'] ) ) {
            $this->setOldFormValues(array( 'title' => $_POST['title'], 'text' => $_POST['text'] ));
            $this->redirect('home/create', 'Security failure! Please try again');
        }

        $result = $this->model->addItem($_POST['title'], $_POST['text']);

        if ( $result ) {
            $this->redirect('', 'TODO note added successfully!');
        } else {
            $this->redirect('', 'Error adding TODO note!');
        }

    }

    /**
     * Deactivate item - set as inactive
     */
    public function deactivate() {

        if ( ! isset($_GET['item_id']) || intval($_GET['item_id']) <= 0 ) {
            $this->redirect('', 'TODO note id missing. Couldn\'t deactivate it');
        }

        // Check nonce
        if ( !isset( $_GET['nonce'] ) || ! $this->checkNonce( $_GET['nonce'] ) ) {
            $this->redirect('', 'Security failure! Please try again!');
        }

        $result = $this->model->deactivate($_GET['item_id']);

        if ( $result ) {
            $this->redirect('', 'TODO note deactivated successfully!');
        } else {
            $this->redirect('', 'Error deactivating TODO note');
        }

    }

    /**
     * Delete item
     */
    public function destroy() {
        if ( ! isset($_GET['item_id']) || intval($_GET['item_id']) <= 0 ) {
            $this->redirect('', 'TODO note id missing. Couldn\'t delete it!');
        }

        // Check nonce
        if ( !isset( $_GET['nonce'] ) || ! $this->checkNonce( $_GET['nonce'] ) ) {
            $this->redirect('', 'Security failure! Please try again');
        }

        $result = $this->model->destroy($_GET['item_id']);

        if ( $result ) {
            $this->redirect('', 'TODO note deleted successfully!');
        } else {
            $this->redirect('', 'Error deleting TODO note!');
        }
    }

    /**
     * List all items in index view without pagination
     */
    private function listAll() {

        $this->view->items = $this->model->getItems();
        $this->view->paginationHtml = '';
        $this->view->render('home/index.php');
        return;

    }

    /**
     * List all items in index view with pagination
     */
    private function paginate() {

        $page = 1;

        if (!empty($_GET['page']) && $_GET['page'] > 1) {
            $page = $_GET['page'];
        }

        $offset = ($page - 1) * $this->itemsPerPage;
        $limit = $this->itemsPerPage;

        $pagesCount = ceil($this->itemsCount / $this->itemsPerPage);
        $this->pagesCount = $pagesCount;
        $this->currentPage = $page;
        $this->paginationItems = 2;
        $this->paginationUrl = URL . 'home';

        $this->view->items = $this->model->getItems($offset, $limit);
        $this->view->paginationHtml = $this->paginationHtml();
        $this->view->render('home/index.php');

    }

    /**
     * Return pagination html
     * @return string
     */
    private function paginationHtml() {

        $output = '';

        if($this->pagesCount > 0) {

            $output .= '<ul class="pagination mdl-cell mdl-cell--12-col">';

                $current_page = $this->currentPage;

                if ($current_page != 1) {
                    $previous = $this->currentPage - 1;
                    $output .= '<li class="pagination__first"><a href="' . $this->paginationUrl . '?page=1">First</a><span>...</span></li>';
                    $output .= '<li class="pagination__previous"><a href="' . $this->paginationUrl . '?page=' . $previous . '" class="pagination__previous">Previous</a></li>';
                }
                for ($i = 1; $i <= $this->pagesCount; $i++) {
                    if ($i == $this->currentPage) {
                        $output .= '<li class="pagination__current"><a href="' . $this->paginationUrl . '?page=' . $i . '">' . $i . '</a></li>';
                    } else {
                        $output .= '<li class="pagination__other"><a href="' . $this->paginationUrl . '?page=' . $i . '">' . $i . '</a></li>';
                    }
                }
                if ($current_page != $this->pagesCount) {
                    $next = $this->currentPage + 1;
                    $output .= '<li class="pagination__next"><a href="' . $this->paginationUrl . '?page=' . $next . '">Next</a></li>';
                    $output .= '<li class="pagination__last"><span>...</span><a href="' . $this->paginationUrl . '?page=' . $this->pagesCount . '">Last</a></li>';
                }

            $output .= '</ul>';

        }

        return $output;

    }
}