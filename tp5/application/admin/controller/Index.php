<?php

namespace app\admin\controller;

/**
 * 
 */
class Index extends \think\Controller
{
	const PAGINATE_PAGE = 10;



	public function index()
	{
		return $this->fetch();
	}

	public function view_category()
	{
		$db = db('category');
		$result = $db->order('id desc')->paginate(Index::PAGINATE_PAGE);
		$this->assign(['result' => $result]);

		return $this->fetch();
	}

	public function add_category()
	{
		if (request()->isGet())
			return $this->fetch();
		else if (request()->isPost()) {
			
			try {
				$name = input('post.name');
				$description = input('post.description');

				if ($name != '') {

					$db = db('category');

					$result = $db->where('name', $name)->select();
					if (count($result) > 0) {
						echo '<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong> Warning!</strong> 🤕Operation failed! Category <strong>' . $name . '</strong> already exists. </div>';

						$result = $db->order('id desc')->paginate(Index::PAGINATE_PAGE);
						$this->assign(['result' => $result]);
						return $this->fetch('view_category');
					}

					if ($description != '') {
						$db->insertGetId(['name' => $name, 'description' => $description]);
					} else {
						$db->insertGetId(['name' => $name]);
					}


					$result = $db->order('id desc')->paginate(Index::PAGINATE_PAGE);
					$this->assign(['result' => $result]);

					echo '<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong> Well done!</strong> You successfully added <strong>' . $name . '</strong> category👌 </div>';

					return $this->fetch('view_category');
				}
			} catch (\think\exception\PDOException $e) {
				echo '<h1>Sorry, database error occurred😐</h1>';
				echo '<h1>We hope you report this error to our website administrator🙃</h1>';
			}
		}
	}

	public function edit_category($category_id = '', $name = '', $description = '')
	{
		if (request()->isGet()) {
			$db = db('category');
			$result = $db->order('id desc')->paginate(Index::PAGINATE_PAGE);
			$this->assign(['result' => $result]);

			return $this->fetch();
		} else if (request()->isPost()) {
			try {
				if ($name != '') {


					$db = db('category');
					$db->where('id', $category_id) -> update(['name' => $name, 'description' => $description]);



					$result = $db->order('id desc')->paginate(Index::PAGINATE_PAGE);
					$this->assign(['result' => $result]);

					echo '<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong> Well done!</strong> You successfully updated <strong>' . $name . '</strong> category👌 </div>';

					return $this->fetch('view_category');
				}
			} catch (\think\exception\PDOException $e) {
				echo '<h1>Sorry, database error occurred😐</h1>';
				echo '<h1>We hope you report this error to our website administrator🙃</h1>';
			}
		}
	}

	public function remove_category($id = 0)
	{
		if (request()->isGet()) {
			$db = db('category');
			$result = $db->order('id desc')->paginate(Index::PAGINATE_PAGE);
			$this->assign(['result' => $result]);

			return $this->fetch();
		} else if (request()->isPost()) {
			try {
				if ($id != '') {

					$db = db('category');

					$entry = $db->where('id', $id)->select();
					$category_name = $entry[0]['name'];

					$result = $db->delete([$id]);



					$result = $db->order('id desc')->paginate(Index::PAGINATE_PAGE);
					$this->assign(['result' => $result]);

					echo '<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong> Well done!</strong> You removed <strong>' . $category_name . '</strong> category successfully👌 </div>';

					return $this->fetch('view_category');
				}
			} catch (\think\exception\PDOException $e) {
				echo '<h1>Sorry, database error occurred😐</h1>';
				echo '<h1>We hope you report this error to our website administrator🙃</h1>';
			}
		}
	}
}
