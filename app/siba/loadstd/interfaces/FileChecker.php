<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author macuser
 */

namespace Siba\loadstd\interfaces;

interface FileChecker {
    //put your code here
    
    public function checkFileIntegrity(\Siba\loadstd\Models\FileDataSource $file);
    
}
