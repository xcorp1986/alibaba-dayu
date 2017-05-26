<?php

namespace Top\Security;

use Top\Request\TopSdkFeedbackUploadRequest;

class SecretCounterUtil
{
    private $topClient;
    /**
     * @var $cacheClient iCache
     */
    private $cacheClient = null;

    private $counterMap;

    function __construct($client)
    {
        $this->topClient = $client;

        $counterMap = [];
    }

    /*
    * 如果不走缓存模式，析构即调用API回传统计信息
    */
    function __destruct()
    {
        if ($this->cacheClient == null) {

        }
    }

    function report($session)
    {
        $request = new TopSdkFeedbackUploadRequest;
    }

    function setCacheClient(iCache $cache)
    {
        $this->cacheClient = $cache;
    }

    function incrDecrypt($delt, $session, $type)
    {
        $item = getItem($session);
        if ($item == null) {
            $item = new SecretCounter();
            putItem($session, $item);
        }

        if ($type == "nick") {
            $item->$decryptNickNum += $delt;
        } else {
            if ($type == "receiver_name") {
                $item->$decryptReceiverNameNum += $delt;
            } else {
                if ($type == "phone") {
                    $item->$decryptPhoneNum += $delt;
                } else {
                    if ($type == "simple") {
                        $item->$decryptSimpleNum += $delt;
                    }
                }
            }
        }
    }

    function incrEncrypt($delt, $session, $type)
    {
        $item = getItem($session);
        if ($item == null) {
            $item = new SecretCounter();
            putItem($session, $item);
        }

        if ($type == "nick") {
            $item->$encryptNickNum += $delt;
        } else {
            if ($type == "receiver_name") {
                $item->$encryptReceiverNameNum += $delt;
            } else {
                if ($type == "phone") {
                    $item->$encryptPhoneNum += $delt;
                } else {
                    if ($type == "simple") {
                        $item->$encryptSimpleNum += $delt;
                    }
                }
            }
        }
    }

    function getItem($session)
    {
        if ($this->cacheClient == null) {
            return $counterMap[$session];
        } else {
            return $this->cacheClient->getCache('s_'.$session);
        }
    }

    function putItem($session, $item)
    {
        if ($this->cacheClient == null) {
            $counterMap[$session] = $item;
        } else {
            $this->cacheClient->setCache('s_'.$session, $item);
        }
    }
}
