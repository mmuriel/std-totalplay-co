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

interface FileDataChecker {
    //put your code here
    
    public function checkDataIntegrity(\Siba\loadstd\Models\FileDataSource $file);
    
}
