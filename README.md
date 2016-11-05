# Bootstrap-Car-Parts-Catalogue Store
------------
This is a simple example of a car parts catalogue store using php, MySQL, Bootstrap and jQuery. The project demonstrates usage of autocomplete, autosuggest, notifications, table sort, datepicker, google charts ajax and more.


Watch online
------------
The project can be seen online [Here](http://wikishark.com/cars/) 


Create tables and import data
------------

### Database Connection
before starting please create a DB_Connection.php file in models folder. 
example file:

```php
<?php
$servername = "localhost";
$username = "username";
$password = "password";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

mysqli_select_db($conn,"car_parts_shop");
```


### Import Data
```
$ cd sql_data
$ mysql -u username -p database_name < tables_structure.sql
$ mysql -u username -p database_name < data.sql
```

Technologies
------------
* [Bootstrap](http://getbootstrap.com/) 
* [jQuery](https://jquery.com/) 
* [Bootstrap Select](https://silviomoreto.github.io/bootstrap-select/) 
* [Bootstrap Notify](https://github.com/mouse0270/bootstrap-notify) 
* [JS Typeahead](https://twitter.github.io/typeahead.js/) 
* [Google Charts](https://developers.google.com/chart/) 
* [Bootstrap Datepicker](https://bootstrap-datepicker.readthedocs.io/en/latest/) 
* [jQuery Tablesorter](http://tablesorter.com/docs/) 


Operations
------------
Manager can:
* view a list of spare parts currently on stock (quantity > 0)
* view a list of spare parts currently out of stock (quantity 0)
* Search a product
* Edit a product
* Add a new product

Manger can also
* View a sales report
* View best selling parts

Client can:
* view a list of spare parts currently on stock (quantity > 0)
* Search a product
* Buy a product

Each product consists of:
* Part type
* Condition
* Manufactured year
* Textual description, 
* Price (USD)
* Quantity
* Date of insertion to stock


Contributing
------------
We welcome pull requests 


Found a bug?
------------
Please let me know


License
-------

THIS SOFTWARE IS PROVIDED BY ANY CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
