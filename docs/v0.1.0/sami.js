
window.projectVersion = 'v0.1.0';

(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '        <ul>                <li data-name="namespace:MockingMagician" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="MockingMagician.html">MockingMagician</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:MockingMagician_Organic" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="MockingMagician/Organic.html">Organic</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:MockingMagician_Organic_Collection" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="MockingMagician/Organic/Collection.html">Collection</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:MockingMagician_Organic_Collection_Collection" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="MockingMagician/Organic/Collection/Collection.html">Collection</a>                    </div>                </li>                            <li data-name="class:MockingMagician_Organic_Collection_DirectoryCollection" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="MockingMagician/Organic/Collection/DirectoryCollection.html">DirectoryCollection</a>                    </div>                </li>                            <li data-name="class:MockingMagician_Organic_Collection_FileCollection" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="MockingMagician/Organic/Collection/FileCollection.html">FileCollection</a>                    </div>                </li>                            <li data-name="class:MockingMagician_Organic_Collection_InodeCollection" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="MockingMagician/Organic/Collection/InodeCollection.html">InodeCollection</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:MockingMagician_Organic_Exception" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="MockingMagician/Organic/Exception.html">Exception</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:MockingMagician_Organic_Exception_CollectionValueException" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="MockingMagician/Organic/Exception/CollectionValueException.html">CollectionValueException</a>                    </div>                </li>                            <li data-name="class:MockingMagician_Organic_Exception_DirectoryCreateException" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="MockingMagician/Organic/Exception/DirectoryCreateException.html">DirectoryCreateException</a>                    </div>                </li>                            <li data-name="class:MockingMagician_Organic_Exception_DirectoryDeleteException" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="MockingMagician/Organic/Exception/DirectoryDeleteException.html">DirectoryDeleteException</a>                    </div>                </li>                            <li data-name="class:MockingMagician_Organic_Exception_DirectoryMoveException" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="MockingMagician/Organic/Exception/DirectoryMoveException.html">DirectoryMoveException</a>                    </div>                </li>                            <li data-name="class:MockingMagician_Organic_Exception_DirectoryPathException" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="MockingMagician/Organic/Exception/DirectoryPathException.html">DirectoryPathException</a>                    </div>                </li>                            <li data-name="class:MockingMagician_Organic_Exception_FileDeleteException" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="MockingMagician/Organic/Exception/FileDeleteException.html">FileDeleteException</a>                    </div>                </li>                            <li data-name="class:MockingMagician_Organic_Exception_FilePathException" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="MockingMagician/Organic/Exception/FilePathException.html">FilePathException</a>                    </div>                </li>                            <li data-name="class:MockingMagician_Organic_Exception_InodePathException" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="MockingMagician/Organic/Exception/InodePathException.html">InodePathException</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:MockingMagician_Organic_Helper" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="MockingMagician/Organic/Helper.html">Helper</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:MockingMagician_Organic_Helper_Collection" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="MockingMagician/Organic/Helper/Collection.html">Collection</a>                    </div>                </li>                            <li data-name="class:MockingMagician_Organic_Helper_CollectionInterface" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="MockingMagician/Organic/Helper/CollectionInterface.html">CollectionInterface</a>                    </div>                </li>                            <li data-name="class:MockingMagician_Organic_Helper_FSIterator" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="MockingMagician/Organic/Helper/FSIterator.html">FSIterator</a>                    </div>                </li>                            <li data-name="class:MockingMagician_Organic_Helper_FSIteratorOnlyDir" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="MockingMagician/Organic/Helper/FSIteratorOnlyDir.html">FSIteratorOnlyDir</a>                    </div>                </li>                            <li data-name="class:MockingMagician_Organic_Helper_FSIteratorOnlyFiles" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="MockingMagician/Organic/Helper/FSIteratorOnlyFiles.html">FSIteratorOnlyFiles</a>                    </div>                </li>                            <li data-name="class:MockingMagician_Organic_Helper_FilesystemIteratorFactory" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="MockingMagician/Organic/Helper/FilesystemIteratorFactory.html">FilesystemIteratorFactory</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:MockingMagician_Organic_Directory" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="MockingMagician/Organic/Directory.html">Directory</a>                    </div>                </li>                            <li data-name="class:MockingMagician_Organic_File" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="MockingMagician/Organic/File.html">File</a>                    </div>                </li>                            <li data-name="class:MockingMagician_Organic_Inode" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="MockingMagician/Organic/Inode.html">Inode</a>                    </div>                </li>                </ul></div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    
            {"type": "Namespace", "link": "MockingMagician.html", "name": "MockingMagician", "doc": "Namespace MockingMagician"},{"type": "Namespace", "link": "MockingMagician/Organic.html", "name": "MockingMagician\\Organic", "doc": "Namespace MockingMagician\\Organic"},{"type": "Namespace", "link": "MockingMagician/Organic/Collection.html", "name": "MockingMagician\\Organic\\Collection", "doc": "Namespace MockingMagician\\Organic\\Collection"},{"type": "Namespace", "link": "MockingMagician/Organic/Exception.html", "name": "MockingMagician\\Organic\\Exception", "doc": "Namespace MockingMagician\\Organic\\Exception"},{"type": "Namespace", "link": "MockingMagician/Organic/Helper.html", "name": "MockingMagician\\Organic\\Helper", "doc": "Namespace MockingMagician\\Organic\\Helper"},
            {"type": "Interface", "fromName": "MockingMagician\\Organic\\Helper", "fromLink": "MockingMagician/Organic/Helper.html", "link": "MockingMagician/Organic/Helper/CollectionInterface.html", "name": "MockingMagician\\Organic\\Helper\\CollectionInterface", "doc": "&quot;Interface CollectionInterface.&quot;"},
                                                        {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\CollectionInterface", "fromLink": "MockingMagician/Organic/Helper/CollectionInterface.html", "link": "MockingMagician/Organic/Helper/CollectionInterface.html#method_add", "name": "MockingMagician\\Organic\\Helper\\CollectionInterface::add", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\CollectionInterface", "fromLink": "MockingMagician/Organic/Helper/CollectionInterface.html", "link": "MockingMagician/Organic/Helper/CollectionInterface.html#method_remove", "name": "MockingMagician\\Organic\\Helper\\CollectionInterface::remove", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\CollectionInterface", "fromLink": "MockingMagician/Organic/Helper/CollectionInterface.html", "link": "MockingMagician/Organic/Helper/CollectionInterface.html#method_clear", "name": "MockingMagician\\Organic\\Helper\\CollectionInterface::clear", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\CollectionInterface", "fromLink": "MockingMagician/Organic/Helper/CollectionInterface.html", "link": "MockingMagician/Organic/Helper/CollectionInterface.html#method_isAcceptableValue", "name": "MockingMagician\\Organic\\Helper\\CollectionInterface::isAcceptableValue", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\CollectionInterface", "fromLink": "MockingMagician/Organic/Helper/CollectionInterface.html", "link": "MockingMagician/Organic/Helper/CollectionInterface.html#method_equals", "name": "MockingMagician\\Organic\\Helper\\CollectionInterface::equals", "doc": "&quot;&quot;"},
            
            
            {"type": "Class", "fromName": "MockingMagician\\Organic\\Collection", "fromLink": "MockingMagician/Organic/Collection.html", "link": "MockingMagician/Organic/Collection/Collection.html", "name": "MockingMagician\\Organic\\Collection\\Collection", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "MockingMagician\\Organic\\Collection\\Collection", "fromLink": "MockingMagician/Organic/Collection/Collection.html", "link": "MockingMagician/Organic/Collection/Collection.html#method___construct", "name": "MockingMagician\\Organic\\Collection\\Collection::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Collection\\Collection", "fromLink": "MockingMagician/Organic/Collection/Collection.html", "link": "MockingMagician/Organic/Collection/Collection.html#method_equals", "name": "MockingMagician\\Organic\\Collection\\Collection::equals", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "MockingMagician\\Organic\\Collection", "fromLink": "MockingMagician/Organic/Collection.html", "link": "MockingMagician/Organic/Collection/DirectoryCollection.html", "name": "MockingMagician\\Organic\\Collection\\DirectoryCollection", "doc": "&quot;Class InodeCollection.&quot;"},
                                                        {"type": "Method", "fromName": "MockingMagician\\Organic\\Collection\\DirectoryCollection", "fromLink": "MockingMagician/Organic/Collection/DirectoryCollection.html", "link": "MockingMagician/Organic/Collection/DirectoryCollection.html#method___construct", "name": "MockingMagician\\Organic\\Collection\\DirectoryCollection::__construct", "doc": "&quot;InodeCollection constructor.&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Collection\\DirectoryCollection", "fromLink": "MockingMagician/Organic/Collection/DirectoryCollection.html", "link": "MockingMagician/Organic/Collection/DirectoryCollection.html#method_createFromPaths", "name": "MockingMagician\\Organic\\Collection\\DirectoryCollection::createFromPaths", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Collection\\DirectoryCollection", "fromLink": "MockingMagician/Organic/Collection/DirectoryCollection.html", "link": "MockingMagician/Organic/Collection/DirectoryCollection.html#method_current", "name": "MockingMagician\\Organic\\Collection\\DirectoryCollection::current", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Collection\\DirectoryCollection", "fromLink": "MockingMagician/Organic/Collection/DirectoryCollection.html", "link": "MockingMagician/Organic/Collection/DirectoryCollection.html#method_next", "name": "MockingMagician\\Organic\\Collection\\DirectoryCollection::next", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Collection\\DirectoryCollection", "fromLink": "MockingMagician/Organic/Collection/DirectoryCollection.html", "link": "MockingMagician/Organic/Collection/DirectoryCollection.html#method_key", "name": "MockingMagician\\Organic\\Collection\\DirectoryCollection::key", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Collection\\DirectoryCollection", "fromLink": "MockingMagician/Organic/Collection/DirectoryCollection.html", "link": "MockingMagician/Organic/Collection/DirectoryCollection.html#method_valid", "name": "MockingMagician\\Organic\\Collection\\DirectoryCollection::valid", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Collection\\DirectoryCollection", "fromLink": "MockingMagician/Organic/Collection/DirectoryCollection.html", "link": "MockingMagician/Organic/Collection/DirectoryCollection.html#method_rewind", "name": "MockingMagician\\Organic\\Collection\\DirectoryCollection::rewind", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "MockingMagician\\Organic\\Collection", "fromLink": "MockingMagician/Organic/Collection.html", "link": "MockingMagician/Organic/Collection/FileCollection.html", "name": "MockingMagician\\Organic\\Collection\\FileCollection", "doc": "&quot;Class InodeCollection.&quot;"},
                                                        {"type": "Method", "fromName": "MockingMagician\\Organic\\Collection\\FileCollection", "fromLink": "MockingMagician/Organic/Collection/FileCollection.html", "link": "MockingMagician/Organic/Collection/FileCollection.html#method___construct", "name": "MockingMagician\\Organic\\Collection\\FileCollection::__construct", "doc": "&quot;InodeCollection constructor.&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Collection\\FileCollection", "fromLink": "MockingMagician/Organic/Collection/FileCollection.html", "link": "MockingMagician/Organic/Collection/FileCollection.html#method_createFromPaths", "name": "MockingMagician\\Organic\\Collection\\FileCollection::createFromPaths", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Collection\\FileCollection", "fromLink": "MockingMagician/Organic/Collection/FileCollection.html", "link": "MockingMagician/Organic/Collection/FileCollection.html#method_current", "name": "MockingMagician\\Organic\\Collection\\FileCollection::current", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Collection\\FileCollection", "fromLink": "MockingMagician/Organic/Collection/FileCollection.html", "link": "MockingMagician/Organic/Collection/FileCollection.html#method_next", "name": "MockingMagician\\Organic\\Collection\\FileCollection::next", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "MockingMagician\\Organic\\Collection", "fromLink": "MockingMagician/Organic/Collection.html", "link": "MockingMagician/Organic/Collection/InodeCollection.html", "name": "MockingMagician\\Organic\\Collection\\InodeCollection", "doc": "&quot;Class InodeCollection.&quot;"},
                                                        {"type": "Method", "fromName": "MockingMagician\\Organic\\Collection\\InodeCollection", "fromLink": "MockingMagician/Organic/Collection/InodeCollection.html", "link": "MockingMagician/Organic/Collection/InodeCollection.html#method___construct", "name": "MockingMagician\\Organic\\Collection\\InodeCollection::__construct", "doc": "&quot;InodeCollection constructor.&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Collection\\InodeCollection", "fromLink": "MockingMagician/Organic/Collection/InodeCollection.html", "link": "MockingMagician/Organic/Collection/InodeCollection.html#method_createFromPaths", "name": "MockingMagician\\Organic\\Collection\\InodeCollection::createFromPaths", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Collection\\InodeCollection", "fromLink": "MockingMagician/Organic/Collection/InodeCollection.html", "link": "MockingMagician/Organic/Collection/InodeCollection.html#method_current", "name": "MockingMagician\\Organic\\Collection\\InodeCollection::current", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Collection\\InodeCollection", "fromLink": "MockingMagician/Organic/Collection/InodeCollection.html", "link": "MockingMagician/Organic/Collection/InodeCollection.html#method_next", "name": "MockingMagician\\Organic\\Collection\\InodeCollection::next", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "MockingMagician\\Organic", "fromLink": "MockingMagician/Organic.html", "link": "MockingMagician/Organic/Directory.html", "name": "MockingMagician\\Organic\\Directory", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "MockingMagician\\Organic\\Directory", "fromLink": "MockingMagician/Organic/Directory.html", "link": "MockingMagician/Organic/Directory.html#method___construct", "name": "MockingMagician\\Organic\\Directory::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Directory", "fromLink": "MockingMagician/Organic/Directory.html", "link": "MockingMagician/Organic/Directory.html#method_getFiles", "name": "MockingMagician\\Organic\\Directory::getFiles", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Directory", "fromLink": "MockingMagician/Organic/Directory.html", "link": "MockingMagician/Organic/Directory.html#method_getRecursiveFiles", "name": "MockingMagician\\Organic\\Directory::getRecursiveFiles", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Directory", "fromLink": "MockingMagician/Organic/Directory.html", "link": "MockingMagician/Organic/Directory.html#method_getDirectories", "name": "MockingMagician\\Organic\\Directory::getDirectories", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Directory", "fromLink": "MockingMagician/Organic/Directory.html", "link": "MockingMagician/Organic/Directory.html#method_getRecursiveDirectories", "name": "MockingMagician\\Organic\\Directory::getRecursiveDirectories", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Directory", "fromLink": "MockingMagician/Organic/Directory.html", "link": "MockingMagician/Organic/Directory.html#method_getInodes", "name": "MockingMagician\\Organic\\Directory::getInodes", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Directory", "fromLink": "MockingMagician/Organic/Directory.html", "link": "MockingMagician/Organic/Directory.html#method_getRecursiveInodes", "name": "MockingMagician\\Organic\\Directory::getRecursiveInodes", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Directory", "fromLink": "MockingMagician/Organic/Directory.html", "link": "MockingMagician/Organic/Directory.html#method_delete", "name": "MockingMagician\\Organic\\Directory::delete", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Directory", "fromLink": "MockingMagician/Organic/Directory.html", "link": "MockingMagician/Organic/Directory.html#method_createDirectory", "name": "MockingMagician\\Organic\\Directory::createDirectory", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Directory", "fromLink": "MockingMagician/Organic/Directory.html", "link": "MockingMagician/Organic/Directory.html#method_createSubDirectory", "name": "MockingMagician\\Organic\\Directory::createSubDirectory", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "MockingMagician\\Organic\\Exception", "fromLink": "MockingMagician/Organic/Exception.html", "link": "MockingMagician/Organic/Exception/CollectionValueException.html", "name": "MockingMagician\\Organic\\Exception\\CollectionValueException", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "MockingMagician\\Organic\\Exception\\CollectionValueException", "fromLink": "MockingMagician/Organic/Exception/CollectionValueException.html", "link": "MockingMagician/Organic/Exception/CollectionValueException.html#method___construct", "name": "MockingMagician\\Organic\\Exception\\CollectionValueException::__construct", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "MockingMagician\\Organic\\Exception", "fromLink": "MockingMagician/Organic/Exception.html", "link": "MockingMagician/Organic/Exception/DirectoryCreateException.html", "name": "MockingMagician\\Organic\\Exception\\DirectoryCreateException", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "MockingMagician\\Organic\\Exception\\DirectoryCreateException", "fromLink": "MockingMagician/Organic/Exception/DirectoryCreateException.html", "link": "MockingMagician/Organic/Exception/DirectoryCreateException.html#method___construct", "name": "MockingMagician\\Organic\\Exception\\DirectoryCreateException::__construct", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "MockingMagician\\Organic\\Exception", "fromLink": "MockingMagician/Organic/Exception.html", "link": "MockingMagician/Organic/Exception/DirectoryDeleteException.html", "name": "MockingMagician\\Organic\\Exception\\DirectoryDeleteException", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "MockingMagician\\Organic\\Exception\\DirectoryDeleteException", "fromLink": "MockingMagician/Organic/Exception/DirectoryDeleteException.html", "link": "MockingMagician/Organic/Exception/DirectoryDeleteException.html#method___construct", "name": "MockingMagician\\Organic\\Exception\\DirectoryDeleteException::__construct", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "MockingMagician\\Organic\\Exception", "fromLink": "MockingMagician/Organic/Exception.html", "link": "MockingMagician/Organic/Exception/DirectoryMoveException.html", "name": "MockingMagician\\Organic\\Exception\\DirectoryMoveException", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "MockingMagician\\Organic\\Exception\\DirectoryMoveException", "fromLink": "MockingMagician/Organic/Exception/DirectoryMoveException.html", "link": "MockingMagician/Organic/Exception/DirectoryMoveException.html#method___construct", "name": "MockingMagician\\Organic\\Exception\\DirectoryMoveException::__construct", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "MockingMagician\\Organic\\Exception", "fromLink": "MockingMagician/Organic/Exception.html", "link": "MockingMagician/Organic/Exception/DirectoryPathException.html", "name": "MockingMagician\\Organic\\Exception\\DirectoryPathException", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "MockingMagician\\Organic\\Exception\\DirectoryPathException", "fromLink": "MockingMagician/Organic/Exception/DirectoryPathException.html", "link": "MockingMagician/Organic/Exception/DirectoryPathException.html#method___construct", "name": "MockingMagician\\Organic\\Exception\\DirectoryPathException::__construct", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "MockingMagician\\Organic\\Exception", "fromLink": "MockingMagician/Organic/Exception.html", "link": "MockingMagician/Organic/Exception/FileDeleteException.html", "name": "MockingMagician\\Organic\\Exception\\FileDeleteException", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "MockingMagician\\Organic\\Exception\\FileDeleteException", "fromLink": "MockingMagician/Organic/Exception/FileDeleteException.html", "link": "MockingMagician/Organic/Exception/FileDeleteException.html#method___construct", "name": "MockingMagician\\Organic\\Exception\\FileDeleteException::__construct", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "MockingMagician\\Organic\\Exception", "fromLink": "MockingMagician/Organic/Exception.html", "link": "MockingMagician/Organic/Exception/FilePathException.html", "name": "MockingMagician\\Organic\\Exception\\FilePathException", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "MockingMagician\\Organic\\Exception\\FilePathException", "fromLink": "MockingMagician/Organic/Exception/FilePathException.html", "link": "MockingMagician/Organic/Exception/FilePathException.html#method___construct", "name": "MockingMagician\\Organic\\Exception\\FilePathException::__construct", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "MockingMagician\\Organic\\Exception", "fromLink": "MockingMagician/Organic/Exception.html", "link": "MockingMagician/Organic/Exception/InodePathException.html", "name": "MockingMagician\\Organic\\Exception\\InodePathException", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "MockingMagician\\Organic\\Exception\\InodePathException", "fromLink": "MockingMagician/Organic/Exception/InodePathException.html", "link": "MockingMagician/Organic/Exception/InodePathException.html#method___construct", "name": "MockingMagician\\Organic\\Exception\\InodePathException::__construct", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "MockingMagician\\Organic", "fromLink": "MockingMagician/Organic.html", "link": "MockingMagician/Organic/File.html", "name": "MockingMagician\\Organic\\File", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "MockingMagician\\Organic\\File", "fromLink": "MockingMagician/Organic/File.html", "link": "MockingMagician/Organic/File.html#method___construct", "name": "MockingMagician\\Organic\\File::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\File", "fromLink": "MockingMagician/Organic/File.html", "link": "MockingMagician/Organic/File.html#method_delete", "name": "MockingMagician\\Organic\\File::delete", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "MockingMagician\\Organic\\Helper", "fromLink": "MockingMagician/Organic/Helper.html", "link": "MockingMagician/Organic/Helper/Collection.html", "name": "MockingMagician\\Organic\\Helper\\Collection", "doc": "&quot;Class Collection.&quot;"},
                                                        {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\Collection", "fromLink": "MockingMagician/Organic/Helper/Collection.html", "link": "MockingMagician/Organic/Helper/Collection.html#method___construct", "name": "MockingMagician\\Organic\\Helper\\Collection::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\Collection", "fromLink": "MockingMagician/Organic/Helper/Collection.html", "link": "MockingMagician/Organic/Helper/Collection.html#method_isAcceptableValue", "name": "MockingMagician\\Organic\\Helper\\Collection::isAcceptableValue", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\Collection", "fromLink": "MockingMagician/Organic/Helper/Collection.html", "link": "MockingMagician/Organic/Helper/Collection.html#method_add", "name": "MockingMagician\\Organic\\Helper\\Collection::add", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\Collection", "fromLink": "MockingMagician/Organic/Helper/Collection.html", "link": "MockingMagician/Organic/Helper/Collection.html#method_remove", "name": "MockingMagician\\Organic\\Helper\\Collection::remove", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\Collection", "fromLink": "MockingMagician/Organic/Helper/Collection.html", "link": "MockingMagician/Organic/Helper/Collection.html#method_clear", "name": "MockingMagician\\Organic\\Helper\\Collection::clear", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\Collection", "fromLink": "MockingMagician/Organic/Helper/Collection.html", "link": "MockingMagician/Organic/Helper/Collection.html#method_count", "name": "MockingMagician\\Organic\\Helper\\Collection::count", "doc": "&quot;Count elements of an object.&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\Collection", "fromLink": "MockingMagician/Organic/Helper/Collection.html", "link": "MockingMagician/Organic/Helper/Collection.html#method_getIterator", "name": "MockingMagician\\Organic\\Helper\\Collection::getIterator", "doc": "&quot;Retrieve an external iterator.&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\Collection", "fromLink": "MockingMagician/Organic/Helper/Collection.html", "link": "MockingMagician/Organic/Helper/Collection.html#method_equals", "name": "MockingMagician\\Organic\\Helper\\Collection::equals", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "MockingMagician\\Organic\\Helper", "fromLink": "MockingMagician/Organic/Helper.html", "link": "MockingMagician/Organic/Helper/CollectionInterface.html", "name": "MockingMagician\\Organic\\Helper\\CollectionInterface", "doc": "&quot;Interface CollectionInterface.&quot;"},
                                                        {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\CollectionInterface", "fromLink": "MockingMagician/Organic/Helper/CollectionInterface.html", "link": "MockingMagician/Organic/Helper/CollectionInterface.html#method_add", "name": "MockingMagician\\Organic\\Helper\\CollectionInterface::add", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\CollectionInterface", "fromLink": "MockingMagician/Organic/Helper/CollectionInterface.html", "link": "MockingMagician/Organic/Helper/CollectionInterface.html#method_remove", "name": "MockingMagician\\Organic\\Helper\\CollectionInterface::remove", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\CollectionInterface", "fromLink": "MockingMagician/Organic/Helper/CollectionInterface.html", "link": "MockingMagician/Organic/Helper/CollectionInterface.html#method_clear", "name": "MockingMagician\\Organic\\Helper\\CollectionInterface::clear", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\CollectionInterface", "fromLink": "MockingMagician/Organic/Helper/CollectionInterface.html", "link": "MockingMagician/Organic/Helper/CollectionInterface.html#method_isAcceptableValue", "name": "MockingMagician\\Organic\\Helper\\CollectionInterface::isAcceptableValue", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\CollectionInterface", "fromLink": "MockingMagician/Organic/Helper/CollectionInterface.html", "link": "MockingMagician/Organic/Helper/CollectionInterface.html#method_equals", "name": "MockingMagician\\Organic\\Helper\\CollectionInterface::equals", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "MockingMagician\\Organic\\Helper", "fromLink": "MockingMagician/Organic/Helper.html", "link": "MockingMagician/Organic/Helper/FSIterator.html", "name": "MockingMagician\\Organic\\Helper\\FSIterator", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\FSIterator", "fromLink": "MockingMagician/Organic/Helper/FSIterator.html", "link": "MockingMagician/Organic/Helper/FSIterator.html#method___construct", "name": "MockingMagician\\Organic\\Helper\\FSIterator::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\FSIterator", "fromLink": "MockingMagician/Organic/Helper/FSIterator.html", "link": "MockingMagician/Organic/Helper/FSIterator.html#method_getIterator", "name": "MockingMagician\\Organic\\Helper\\FSIterator::getIterator", "doc": "&quot;Retrieve an external iterator&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\FSIterator", "fromLink": "MockingMagician/Organic/Helper/FSIterator.html", "link": "MockingMagician/Organic/Helper/FSIterator.html#method_scanDir", "name": "MockingMagician\\Organic\\Helper\\FSIterator::scanDir", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "MockingMagician\\Organic\\Helper", "fromLink": "MockingMagician/Organic/Helper.html", "link": "MockingMagician/Organic/Helper/FSIteratorOnlyDir.html", "name": "MockingMagician\\Organic\\Helper\\FSIteratorOnlyDir", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\FSIteratorOnlyDir", "fromLink": "MockingMagician/Organic/Helper/FSIteratorOnlyDir.html", "link": "MockingMagician/Organic/Helper/FSIteratorOnlyDir.html#method___construct", "name": "MockingMagician\\Organic\\Helper\\FSIteratorOnlyDir::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\FSIteratorOnlyDir", "fromLink": "MockingMagician/Organic/Helper/FSIteratorOnlyDir.html", "link": "MockingMagician/Organic/Helper/FSIteratorOnlyDir.html#method_getIterator", "name": "MockingMagician\\Organic\\Helper\\FSIteratorOnlyDir::getIterator", "doc": "&quot;Retrieve an external iterator&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\FSIteratorOnlyDir", "fromLink": "MockingMagician/Organic/Helper/FSIteratorOnlyDir.html", "link": "MockingMagician/Organic/Helper/FSIteratorOnlyDir.html#method_scanDir", "name": "MockingMagician\\Organic\\Helper\\FSIteratorOnlyDir::scanDir", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "MockingMagician\\Organic\\Helper", "fromLink": "MockingMagician/Organic/Helper.html", "link": "MockingMagician/Organic/Helper/FSIteratorOnlyFiles.html", "name": "MockingMagician\\Organic\\Helper\\FSIteratorOnlyFiles", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\FSIteratorOnlyFiles", "fromLink": "MockingMagician/Organic/Helper/FSIteratorOnlyFiles.html", "link": "MockingMagician/Organic/Helper/FSIteratorOnlyFiles.html#method___construct", "name": "MockingMagician\\Organic\\Helper\\FSIteratorOnlyFiles::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\FSIteratorOnlyFiles", "fromLink": "MockingMagician/Organic/Helper/FSIteratorOnlyFiles.html", "link": "MockingMagician/Organic/Helper/FSIteratorOnlyFiles.html#method_getIterator", "name": "MockingMagician\\Organic\\Helper\\FSIteratorOnlyFiles::getIterator", "doc": "&quot;Retrieve an external iterator&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\FSIteratorOnlyFiles", "fromLink": "MockingMagician/Organic/Helper/FSIteratorOnlyFiles.html", "link": "MockingMagician/Organic/Helper/FSIteratorOnlyFiles.html#method_scanDir", "name": "MockingMagician\\Organic\\Helper\\FSIteratorOnlyFiles::scanDir", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "MockingMagician\\Organic\\Helper", "fromLink": "MockingMagician/Organic/Helper.html", "link": "MockingMagician/Organic/Helper/FilesystemIteratorFactory.html", "name": "MockingMagician\\Organic\\Helper\\FilesystemIteratorFactory", "doc": "&quot;Class FilesystemIteratorFactory.&quot;"},
                                                        {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\FilesystemIteratorFactory", "fromLink": "MockingMagician/Organic/Helper/FilesystemIteratorFactory.html", "link": "MockingMagician/Organic/Helper/FilesystemIteratorFactory.html#method___construct", "name": "MockingMagician\\Organic\\Helper\\FilesystemIteratorFactory::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\FilesystemIteratorFactory", "fromLink": "MockingMagician/Organic/Helper/FilesystemIteratorFactory.html", "link": "MockingMagician/Organic/Helper/FilesystemIteratorFactory.html#method_createFileSystemIterator", "name": "MockingMagician\\Organic\\Helper\\FilesystemIteratorFactory::createFileSystemIterator", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\FilesystemIteratorFactory", "fromLink": "MockingMagician/Organic/Helper/FilesystemIteratorFactory.html", "link": "MockingMagician/Organic/Helper/FilesystemIteratorFactory.html#method_createRecursiveFileSystemIterator", "name": "MockingMagician\\Organic\\Helper\\FilesystemIteratorFactory::createRecursiveFileSystemIterator", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\FilesystemIteratorFactory", "fromLink": "MockingMagician/Organic/Helper/FilesystemIteratorFactory.html", "link": "MockingMagician/Organic/Helper/FilesystemIteratorFactory.html#method_createFileSystemIteratorOnlyDirectories", "name": "MockingMagician\\Organic\\Helper\\FilesystemIteratorFactory::createFileSystemIteratorOnlyDirectories", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\FilesystemIteratorFactory", "fromLink": "MockingMagician/Organic/Helper/FilesystemIteratorFactory.html", "link": "MockingMagician/Organic/Helper/FilesystemIteratorFactory.html#method_createRecursiveFileSystemIteratorOnlyDirectories", "name": "MockingMagician\\Organic\\Helper\\FilesystemIteratorFactory::createRecursiveFileSystemIteratorOnlyDirectories", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\FilesystemIteratorFactory", "fromLink": "MockingMagician/Organic/Helper/FilesystemIteratorFactory.html", "link": "MockingMagician/Organic/Helper/FilesystemIteratorFactory.html#method_createFileSystemIteratorOnlyFiles", "name": "MockingMagician\\Organic\\Helper\\FilesystemIteratorFactory::createFileSystemIteratorOnlyFiles", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Helper\\FilesystemIteratorFactory", "fromLink": "MockingMagician/Organic/Helper/FilesystemIteratorFactory.html", "link": "MockingMagician/Organic/Helper/FilesystemIteratorFactory.html#method_createRecursiveFileSystemIteratorOnlyFiles", "name": "MockingMagician\\Organic\\Helper\\FilesystemIteratorFactory::createRecursiveFileSystemIteratorOnlyFiles", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "MockingMagician\\Organic", "fromLink": "MockingMagician/Organic.html", "link": "MockingMagician/Organic/Inode.html", "name": "MockingMagician\\Organic\\Inode", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "MockingMagician\\Organic\\Inode", "fromLink": "MockingMagician/Organic/Inode.html", "link": "MockingMagician/Organic/Inode.html#method_isDirectory", "name": "MockingMagician\\Organic\\Inode::isDirectory", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Inode", "fromLink": "MockingMagician/Organic/Inode.html", "link": "MockingMagician/Organic/Inode.html#method_attachTo", "name": "MockingMagician\\Organic\\Inode::attachTo", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Inode", "fromLink": "MockingMagician/Organic/Inode.html", "link": "MockingMagician/Organic/Inode.html#method_detachFromCollection", "name": "MockingMagician\\Organic\\Inode::detachFromCollection", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Inode", "fromLink": "MockingMagician/Organic/Inode.html", "link": "MockingMagician/Organic/Inode.html#method_delete", "name": "MockingMagician\\Organic\\Inode::delete", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "MockingMagician\\Organic\\Inode", "fromLink": "MockingMagician/Organic/Inode.html", "link": "MockingMagician/Organic/Inode.html#method_moveTo", "name": "MockingMagician\\Organic\\Inode::moveTo", "doc": "&quot;&quot;"},
            
            
                                        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function() {

    // Enable the version switcher
    $('#version-switcher').change(function() {
        window.location = $(this).val()
    });

    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').click(function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Sami.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


