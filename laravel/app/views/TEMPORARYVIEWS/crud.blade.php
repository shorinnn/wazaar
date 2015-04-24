    @extends('layouts.default')
    @section('content')	
    <div class="crud-wrapper">
    	<div class="crud-components clearfix">
        	<div class="table-wrapper table-responsive">
            	<span class="table-title">SALES
                     <div class="activate-dropdown">
                        <button aria-expanded="false" data-toggle="dropdown" 
                                class="btn btn-default dropdown-toggle" type="button" id="btnGroupDrop1">
                            View
                        </button>
                        <ul id="table-header-dropdown" aria-labelledby="btnGroupDrop1" role="menu" class="dropdown-menu">
                            <li>
                                <a class="profile-button" href="#">10s</a>
                            </li>
                            <li>
                                <a class="courses-button" href="#">20s</a>
                            </li>
                            <li>
                                <a class="settings-button" href="#">30s</a>
                            </li>
                            <li>
                                <a class="settings-button" href="#">40s</a>
                            </li>
                        </ul>
                    </div>               
                </span>
                <table class="table table-bordered table-striped">
                	<thead>
                    	<tr>
                        	<th>ID</th>
                        	<th>AMOUNT</th>
                        	<th>TRACKING ID</th>
                        	<th>TITLE</th>
                        	<th>TITLE</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<tr>
                        	<td>SAMPLE CONTENT</td>
                        	<td>SAMPLE CONTENT</td>
                        	<td>SAMPLE CONTENT</td>
                        	<td>SAMPLE CONTENT</td>
                        	<td>SAMPLE CONTENT</td>
                        </tr>
                    	<tr>
                        	<td>SAMPLE CONTENT</td>
                        	<td>SAMPLE CONTENT</td>
                        	<td>SAMPLE CONTENT</td>
                        	<td>SAMPLE CONTENT</td>
                        	<td>SAMPLE CONTENT</td>
                        </tr>
                    	<tr>
                        	<td>SAMPLE CONTENT</td>
                        	<td>SAMPLE CONTENT</td>
                        	<td>SAMPLE CONTENT</td>
                        	<td>SAMPLE CONTENT</td>
                        	<td>SAMPLE CONTENT</td>
                        </tr>
                    	<tr>
                        	<td>SAMPLE CONTENT</td>
                        	<td>SAMPLE CONTENT</td>
                        	<td>SAMPLE CONTENT</td>
                        	<td>SAMPLE CONTENT</td>
                        	<td>SAMPLE CONTENT</td>
                        </tr>
                    	<tr>
                        	<td>SAMPLE CONTENT</td>
                        	<td>SAMPLE CONTENT</td>
                        	<td>SAMPLE CONTENT</td>
                        	<td>SAMPLE CONTENT</td>
                        	<td>SAMPLE CONTENT</td>
                        </tr>
                    	<tr>
                        	<td>SAMPLE CONTENT</td>
                        	<td>SAMPLE CONTENT</td>
                        	<td>SAMPLE CONTENT</td>
                        	<td>SAMPLE CONTENT</td>
                        	<td>SAMPLE CONTENT</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="pagination-container clearfix">
            	<div class="page-numbers-container clearfix">
                    <a href="#" class="directions left"></a>
                    <ul class="clearfix">
                        <li>
                            <a href="#">1</a>
                        <li>
                            <a href="#">2</a>
                        <li>
                            <a href="#" class="active">3</a>
                        <li>
                            <a href="#">4</a>
                        <li>
                            <a href="#">...</a>
                        <li>
                            <a href="#">100</a>
                        </li>
                    </ul>
                    <a href="#" class="directions right"></a>
                    <div class="skip-to">
                    	<span>SKIP TO</span>
                        <input type="text" name="skip-to">
                    </div>
                </div>
            </div>
            <div class="dropdown-container clearfix">
                <div class="menu-dropdown dropdown-1">
                    <button aria-expanded="false" value="" data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" id="btnGroupDrop1">
                        Dropdown if you want to...
                    </button>
                    <ul aria-labelledby="btnGroupDrop1" role="menu" class="dropdown-menu">
                        <li>
                            <a class="#" href="#">Dropdown text</a>
                        </li>
                        <li>
                            <a class="#" href="#">Dropdown text</a>
                        </li>
                        <li>
                            <a class="#" href="#">Dropdown text</a>
                        </li>
                        <li>
                            <a class="#" href="#">Dropdown text</a>
                        </li>
                    </ul>
                </div>
                <div class="menu-dropdown dropdown-2">
                    <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" id="btnGroupDrop1">
                        Dropdown if you want to...
                    </button>
                    <ul aria-labelledby="btnGroupDrop1" role="menu" class="dropdown-menu">
                        <li>
                            <a class="#" href="#">Dropdown text</a>
                        </li>
                        <li>
                            <a class="#" href="#">Dropdown text</a>
                        </li>
                        <li>
                            <a class="#" href="#">Dropdown text</a>
                        </li>
                        <li>
                            <a class="#" href="#">Dropdown text</a>
                        </li>
                    </ul>
                </div>
                <div class="menu-dropdown" id="dropdown-3">
                    <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" id="btnGroupDrop1">
                        Dropdown if you want to...
                    </button>
                    <ul aria-labelledby="btnGroupDrop1" role="menu" class="dropdown-menu">
                        <li>
                            <a class="#" href="#">Dropdown text</a>
                        </li>
                        <li>
                            <a class="#" href="#">Dropdown text</a>
                        </li>
                        <li>
                            <a class="#" href="#">Dropdown text</a>
                        </li>
                        <li>
                            <a class="#" href="#">Dropdown text</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="radio-buttons clearfix">
                <div class="radio-item">
                  <div class="radio-checkbox radio-checked">
                    <input name="radio-button" id="radio-1" autocomplete="off" checked="checked" type="radio">                       
                    <label for="radio-1" class="small-radio">
                    </label>
                  </div>
                </div><!-- end radio item -->
                <div class="radio-item">
                  <div class="radio-checkbox">
                    <input id="radio-2" autocomplete="off" name="radio-button" type="radio">                        
                    <label for="radio-2" class="small-radio">
                    </label>
                  </div>
                </div><!-- end radio item -->
                <div class="radio-item">
                  <div class="radio-checkbox radio-checked">
                    <input name="radio-button" id="radio-3" autocomplete="off" type="radio">                       
                    <label for="radio-3" class="big-radio">
                    </label>
                  </div>
                </div><!-- end radio item -->
                <div class="radio-item">
                  <div class="radio-checkbox">
                    <input id="radio-4" autocomplete="off" name="radio-button" type="radio">                        
                    <label for="radio-4" class="big-radio">
                    </label>
                  </div>
                </div><!-- end radio item -->
          	</div>
            <div class="checkbox-buttons">
                <div class="checkbox-item">
                  <div class="checkbox-checkbox checkbox-checked">
                    <input id="checkbox-1" autocomplete="off" checked="checked" type="checkbox">                        
                    <label for="checkbox-1" class="small-checkbox">
                    </label>
                  </div>  
                </div><!-- end checkbox item -->
                <div class="checkbox-item">
                  <div class="checkbox-checkbox">
                    <input id="checkbox-2" autocomplete="off" type="checkbox">                       
                    <label for="checkbox-2" class="small-checkbox">
                    </label>
                  </div>
                </div><!-- end checkbox item -->
                <div class="checkbox-item">
                  <div class="checkbox-checkbox checkbox-checked">
                    <input id="checkbox-3" autocomplete="off" type="checkbox">                        
                    <label for="checkbox-3"  class="big-checkbox">
                    </label>
                  </div>  
                </div><!-- end checkbox item -->
                <div class="checkbox-item">
                  <div class="checkbox-checkbox">
                    <input id="checkbox-4" autocomplete="off" type="checkbox">                       
                    <label for="checkbox-4" class="big-checkbox">
                    </label>
                  </div>
                </div><!-- end checkbox item -->
            </div>
            <div class="switch-buttons">
                <label class="switch">
                  <input type="checkbox" class="switch-input">
                  <span class="switch-label" data-on="On" data-off="Off"></span>
                  <span class="switch-handle"></span>
                </label>
            </div>
            <div class="submit-button">
            	<button type="submit" class="submit submit-button-1">Submit</button>
            	<button type="submit" class="submit submit-button-2">Submit</button>
            	<button type="submit" class="submit submit-button-3">Submit</button>
            	<button type="submit" class="submit submit-button-4">Submit</button>
            </div>
            <div class="file-upload">
            	<button type="button" class="browse-button-1">BROWSE</button>
            	<button type="button" class="browse-button-2">BROWSE</button>
                <div>
                	<input type="text" placeholder="no file selected">
                    <button type="button">BROWSE</button>
                </div>
            </div>
        </div>
    </div>
    @stop