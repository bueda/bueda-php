<?php

/**
 * BuedaRequest class encapsulates the functionality required to make a request
 * to Bueda Web Service.
 *
 * @author Vignesh
 */
class BuedaRequest {

    // <string> : Domain of bueda request url
    private $domain = "http://api.bueda.com/enriched?";

    // <string> : API key of the user
    private $api_key;

    // <string> : comma-separated string of the tags
    private $tags;

    // <resource> : CURL resource handler
    private $curl_resource;

    /**
     * Initializes a BuedaRequest Object with the specified api key and tags
     *
     * @param <string> $api_key : your bueda api key
     * @param <array> $parameters : comma-separated string of tags
     */
    function __construct($api_key,$tags=NULL) {

        $this->api_key = $api_key;

        if(isset($tags)) {
            // If the $tags parameter is a string, assign it to the $tags instance variable
            if(is_string($tags)) {
                $this->tags = $tags;
            }
            else{
                throw new InvalidTagException("Invalid tags supplied. The supplied tag(s):".$tags);    
            }
        }

        $this->curl_resource = curl_init();
        curl_setopt($this->curl_resource, CURLOPT_RETURNTRANSFER, 1);
    }

    /**
     * Adds a tag or comma-separated string of tags to the existing tag list
     *
     * @param <mixed> $tag : new tag(or string of tags) to be added to the existing tag list
     */
    function addTags($tags) {

        if(!isset($this->tags)){
            $this->reloadTags($tags);
            return ;
        }

        // If the $tags parameter is a string, assign it to the $tags instance variable
        if(is_string($tags)) {
            $this->tags .= ",".$tags;
        }
        else{
            throw new InvalidTagException("Invalid tags supplied. The supplied tag(s):".$tags);    
        }
    }

    /**
     * Reloads the existing tag list with the given tag or comma-separated string of tags. Removes
     * the already available tags in the current object
     *
     * @param <mixed> $tags : new tag(or comma-separated string of tags)
     */
    function reloadTags($tags) {

        // If the $tags parameter is a string, assign it to the $tags instance variable
        if(is_string($tags)) {
            $this->tags = $tags;
        }
        else{
            throw new InvalidTagException("Invalid tags supplied. The supplied tag(s):".$tags);    
        }

    }

    /**
     * Executes the query and returns the json object as an associative array.
     * Throws an error if tags are not already supplied to the current object.
     *
     * @return <array> : associative array representing the json object
     */
    function execute() {

        if(!$this->tags) {
            throw new TagNotSuppliedException("Tags not available to complete the request");
        }

        // Contruct the URL with the necessary details
        $url = $this->domain."apikey=".$this->api_key."&tags=".$this->tags;        

        // Set the URL, execute and obtain the response as json text string
        curl_setopt($this->curl_resource, CURLOPT_URL, $url);
        $response = curl_exec($this->curl_resource);        

        // Parse the json text string to product json object represented as an associate array
        $json = json_decode($response,true);

        return $json;
    }

    function __destruct() {        
        curl_close($this->curl_resource);
    }

    /**
     * Used for testing only
     * @return <type>
     */
    private function getURLString() {
        return $this->domain."apikey=".$this->api_key."&tags=".$this->tags;
    }

    function __toString(){
        return $this->getURLString();
    }
}
?>
