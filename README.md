# Paginator

This is yet another paginator for php.
Main idea of this package is to build data source independent paginator, which has an ability to work in several modes:
 
- Count skip by id
    ```php
        $loader = function (int $limit, int $skip): iterable
        {
            //SELECT * from users  WHERE id > $skip LIMIT $limit
        };
        
        $perPage = 100;
        $lastIdOnPreviousPage = 34;
        
        $paginatorFactory = new SkipById($perPage);
      
        $page = $paginatorFactory
            ->createPaginator(new CallableLoader($loader), $lastIdOnPreviousPage)
            ->paginate()
        ;
    ```
    In this example you have an ability use `id` as skip value. 
    As you can see, Loader function accepts `id` in `$skip` variable. 
    It should be `id` of last item on previous page and it comes from client side.
    For 1st page it should be 0. 
    It will use same logic for `$page->hasNext`, because it has no Counter param.
  
    Optionally, you can set `$currentPage` value, wich will be set to `$page->currentPage`.
  
- Count skip by id with total count
  ```php
     $loader = function (int $limit, int $skip): iterable {
         //SELECT * from users  WHERE id > $skip LIMIT
     };
    
     $counter = function (): int {
         //SELECT count(id) from users
     };
     
     $perPage = 100;
     $lastIdOnPreviousPage = 35;
     
     $paginatorFactory = new SkipByIdCountable($perPage);
     $page = $paginatorFactory
         ->createPaginator(
             new CallableLoader($loader),
             new CallableCounter($counter),
             $lastIdOnPreviousPage
         )
         ->paginate()
     ;
   ```
  In above example paginator counts skip by id and uses total count for
  `$page->total`, `$page->totalPages` values.
  For `$page->hasNext` paginator will load `$perPage + 1` item,
  and then check if actual count of loaded items is more than `$perPage`.

- Count skip by id with total count and current page
  ```php
     $loader = function (int $limit, int $skip): iterable {
         //SELECT * from users  WHERE id > $skip LIMIT
     };
    
     $counter = function (): int {
         //SELECT count(id) from users
     };
     
     $perPage = 100;
     $lastIdOnPreviousPage = 35;
     $currentPage = 4;
     
     $paginatorFactory = new SkipByIdCountable($perPage);
     $page = $paginatorFactory
         ->createPaginator(
             new CallableLoader($loader),
             new CallableCounter($counter),
             $lastIdOnPreviousPage,
             $currentPage
         )
         ->paginate()
     ;
   ```
  In above example paginator counts skip by id and uses total count for
  `$page->total`, `$page->totalPages`, `$page->hasNext` values.
  In this case, we know `$currentPage` value, which in real case comes from client,
  so we can use total count and `$currentPage` for counting `$page->hasNext` except
  using `$perPage + 1` strategy.
   
- Count skip by offset
    ```php
    $loader = function (int $limit, int $skip): iterable
    {
        //SELECT * from users LIMIT $limit OFFSET $skip
    };
  
    $perPage = 100;
    $currentPage = 2;
    
    $paginatorFactory = new SkipByOffset($perPage);
  
    $page = $paginatorFactory
        ->createPaginator(new CallableLoader($loader), $currentPage)
        ->paginate()
    ;
    ```
    In above example paginator counts skip as offset according to $perPage and $currentPage values.
    For counting `$page->hasNext` paginator will load `$perPage + 1` item,
    and then check if actual count of loaded items is more than `$perPage`.
     
  - Count skip by offset and use total count
    ```php
       $loader = function (int $limit, int $skip): iterable {
           //SELECT * from users LIMIT $limit OFFSET $skip
       };
      
       $counter = function (): int {
           //SELECT count(id) from users
       };
       
       $perPage = 100;
       $currentPage = 2;
       
       $paginatorFactory = new SkipByOffsetCountable($perPage);
   
       $page = $paginatorFactory
           ->createPaginator(new CallableLoader($loader), new CallableCounter($counter), $currentPage)
           ->paginate()
       ;

     ```
    
    In above example paginator counts skip by offset and uses total count for
    `$page->total`, `$page->totalPages`, `$page->hasNext` values.