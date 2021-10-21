<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AdminPostsController extends BaseController
{
	public function index()
	{
		$PostModel = model("PostModel");
		$data = [
			'posts' => $PostModel->findAll()
		];
		return view("posts/index", $data);
	}

	public function create()
	{
		session();
		$data = [
			'validation' => \Config\Services::validation(),
		];
		return view("posts/create", $data);
	}

	public function store()
	{
		$valid = $this->validate([
			"judul" => [
				"label" => "Judul",
				"rules" => "required",
				"error" => [
					"required" => "{field} Harus diisi!",
				]
			],
			"slug" => [
				"label" => "Slug",
				"rules" => "required|is_unique[posts.slug]",
				"error" => [
					"required" => "{field} Harus diisi!",
					"is_unique" => "{field} Sudah ada!"
				]
			],
			"kategori" => [
				"label" => "Kategori",
				"rules" => "required",
				"error" => [
					"required" => "{field} Harus diisi!",
				]
			],
			"author" => [
				"label" => "Author",
				"rules" => "required",
				"error" => [
					"required" => "{field} Harus diisi!",
				]
			],
			"deskripsi" => [
				"label" => "Deskripsi",
				"rules" => "required",
				"error" => [
					"required" => "{field} Harus diisi!",
				]
			],
		]);
		# dd($valid);

		if ($valid){
			$data = [
				'judul' => $this->request->getVar('judul'),
				'slug' => $this->request->getVar("slug"),
				'kategori' => $this->request->getVar("kategori"),
				'author' => $this->request->getVar("author"),
				'deskripsi' => $this->request->getVar("deskripsi"),
			];
			# dd($data);

			$PostModel = model("PostModel");
			$PostModel->insert($data);
			return redirect()->to(base_url('admin/posts'));
	
		} else {
			return redirect()->to(base_url('admin/posts/create'))->withInput()->with('validation', $this->validator);
		}
	}
}
