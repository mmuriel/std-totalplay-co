<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Siba\loadstd\interfaces;
/**
 *
 * @author macuser
 */
interface FileMover {
    //put your code here
    public function moveFileToPath (\Siba\loadstd\Models\FileDataSource $file,$path);
}