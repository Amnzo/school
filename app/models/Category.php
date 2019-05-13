<?php

class Category extends Eloquent {
	
	protected $guarded = ['id', 'created_at'];

	protected $table = 'categories';

	public function articles()
	{
		return $this->hasMany('Article');
	}

}