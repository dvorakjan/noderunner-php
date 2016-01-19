<?php

namespace NodeRunner;

class Job implements IJob {

    protected $tags = [];
    protected $ignoredProperties = ['ignoredProperties'];

    public function toArray()
    {
        // get all non ignored properties
        $props = array_diff_key(get_object_vars($this), array_flip($this->ignoredProperties));

        // remove _ properties keys prefixes
        $props = array_combine(
                    array_map(function($a){ return strpos($a, '_') === 0 ? substr($a, 1) : $a; }, array_keys($props)),
                    array_values($props)
                 );

        // remove null values and empty arrays
        $props = array_filter($props, function($val) {
            return (is_array($val) && !empty($val)) || (!is_array($val) && !is_null($val));
        });

        $props['added'] = round(microtime(true) * 1000);

        return $props;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     * @return Job
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @param $tag
     * @return $this
     */
    public function addTag($tag) {
        $this->tags[] = $tag;
        return $this;
    }

    /**
     * @return array
     */
    public function getIgnoredProperties()
    {
        return $this->ignoredProperties;
    }

    /**
     * @param array $ignoredProperties
     * @return Job
     */
    public function setIgnoredProperties($ignoredProperties)
    {
        $this->ignoredProperties = $ignoredProperties;
        return $this;
    }

    /**
     * @param array $ignoredProperties
     * @return Job
     */
    public function addIgnoredProperties($ignoredProperties)
    {
        $this->ignoredProperties = array_merge($this->ignoredProperties, $ignoredProperties);
        return $this;
    }
}