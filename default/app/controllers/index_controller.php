<?php

/**
 * Controller por defecto si no se usa el routes
 *
 */
View::template("login");
class IndexController extends AppController
{
  public function before_filter()
  {
    if (!Auth::is_valid()) {
      Router::redirect("login/index");
    }
  }

  public function index()
  {
     Router::redirect("home/index");
  }

}
