<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PostModel;

class AdminPostsController extends BaseController
{
	public function __construct(){
		$this->PostModel = new PostModel();
	}

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
			session()->setFlashdata('pesan', 'Data berhasil ditambahkan!');
			return redirect()->to(base_url('admin/posts'));
	
		} else {
			return redirect()->to(base_url('admin/posts/create'))->withInput()->with('validation', $this->validator);
		}
	}

	public function edit($post_id)
	{
		$data = [
			'title' => 'Form Edit Data',
			'validation' => \Config\Services::validation(),
			'post' => $this->PostModel->getPosts($post_id)
		];
		return view("posts/edit", $data);
	}

	public function update($post_id)
	{
		# dd($this->request->getVar());

		$valid = $this->validate([
			"judul" => [
				"label" => "Judul",
				"rules" => "required",
				"error" => [
					"required" => "{field} Harus diisi!",
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
				'post_id' => $post_id,
				'judul' => $this->request->getVar('judul'),
				'kategori' => $this->request->getVar("kategori"),
				'author' => $this->request->getVar("author"),
				'deskripsi' => $this->request->getVar("deskripsi"),
			];
			# dd($data);

			$PostModel = model("PostModel");
			$PostModel->insert($data);
			session()->setFlashdata('pesan', 'Data berhasil diedit!');
			return redirect()->to(base_url('admin/posts'));
	
		} else {
			session()->setFlashdata('pesan1', 'Data tidak berhasil diedit!');
			return redirect()->to('/admin/posts');
		}
	}

	public function delete($post_id)
	{
		$this->PostModel->delete($post_id);
		session()->setFlashdata('pesan', 'Data berhasil dihapus!');
		return redirect()->to('/admin/posts');
	}
}
