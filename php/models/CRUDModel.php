<?php

abstract class CRUDModel {
	public abstract function create();
	public static abstract function read();
	public abstract function update();
	public abstract function delete();
}
