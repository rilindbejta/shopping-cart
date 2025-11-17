import { Head, Link, router, usePage } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { useState } from 'react';

export default function Index({ products }) {
    const { auth } = usePage().props;
    const [addingToCart, setAddingToCart] = useState(null);

    const handleAddToCart = (productId) => {
        setAddingToCart(productId);
        
        router.post(route('cart.store'), {
            product_id: productId,
            quantity: 1,
        }, {
            preserveScroll: true,
            onFinish: () => setAddingToCart(null),
        });
    };

    return (
        <AuthenticatedLayout
            header={
                <div className="flex justify-between items-center">
                    <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                        Products
                    </h2>
                    {auth.user && (
                        <Link
                            href={route('cart.index')}
                            className="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:bg-white dark:focus:ring-offset-gray-800 dark:active:bg-gray-300"
                        >
                            🛒 Cart ({auth.cartCount || 0})
                        </Link>
                    )}
                </div>
            }
        >
            <Head title="Products" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {!auth.user && (
                        <div className="mb-6 overflow-hidden bg-yellow-50 shadow-sm sm:rounded-lg dark:bg-yellow-900">
                            <div className="p-6 text-yellow-900 dark:text-yellow-100">
                                <p className="font-semibold">Please login to add products to your cart.</p>
                                <div className="mt-4 flex gap-4">
                                    <Link
                                        href={route('login')}
                                        className="text-yellow-700 underline hover:text-yellow-900 dark:text-yellow-300 dark:hover:text-yellow-100"
                                    >
                                        Log in
                                    </Link>
                                    <Link
                                        href={route('register')}
                                        className="text-yellow-700 underline hover:text-yellow-900 dark:text-yellow-300 dark:hover:text-yellow-100"
                                    >
                                        Register
                                    </Link>
                                </div>
                            </div>
                        </div>
                    )}

                    <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        {products.map((product) => (
                            <div
                                key={product.id}
                                className="overflow-hidden bg-white shadow-sm transition-shadow hover:shadow-md sm:rounded-lg dark:bg-gray-800"
                            >
                                <div className="p-6">
                                    <h3 className="mb-2 text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {product.name}
                                    </h3>
                                    
                                    {product.description && (
                                        <p className="mb-4 text-sm text-gray-600 dark:text-gray-400">
                                            {product.description}
                                        </p>
                                    )}

                                    <div className="mb-4">
                                        <span className="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                            ${product.price}
                                        </span>
                                    </div>

                                    <div className="mb-4">
                                        {product.is_in_stock ? (
                                            <span
                                                className={`text-sm ${
                                                    product.is_low_stock
                                                        ? 'text-yellow-600 dark:text-yellow-400'
                                                        : 'text-green-600 dark:text-green-400'
                                                }`}
                                            >
                                                {product.stock_quantity} in stock
                                                {product.is_low_stock && ' (Low Stock!)'}
                                            </span>
                                        ) : (
                                            <span className="text-sm text-red-600 dark:text-red-400">
                                                Out of Stock
                                            </span>
                                        )}
                                    </div>

                                    {auth.user && (
                                        <button
                                            onClick={() => handleAddToCart(product.id)}
                                            disabled={!product.is_in_stock || addingToCart === product.id}
                                            className="w-full rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900 disabled:opacity-50 disabled:cursor-not-allowed dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:bg-white dark:focus:ring-offset-gray-800 dark:active:bg-gray-300"
                                        >
                                            {addingToCart === product.id ? 'Adding...' : 'Add to Cart'}
                                        </button>
                                    )}
                                </div>
                            </div>
                        ))}
                    </div>

                    {products.length === 0 && (
                        <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                            <div className="p-6 text-center text-gray-900 dark:text-gray-100">
                                <p className="text-lg">No products available at the moment.</p>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

