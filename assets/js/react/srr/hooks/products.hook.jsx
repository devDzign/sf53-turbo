import React, { useCallback, useState } from 'react';
import { jsonLdFetch } from "../api/user.api";


const useProductsList = (url) => {

    const [loading, setLoading] = useState(false);
    const [products, setProducts] = useState([]);

    const onLoadHandler = useCallback( async () => {
        setLoading(true);

        try {
            const data =  await jsonLdFetch(url);
            setProducts(data)

        } catch (e) {
            console.log(e)
        }

        setLoading(false)

    }, [url])


    return {
        loading,
        onLoadHandler,
        products
    }
}

export default useProductsList;

