import { Head, Link, router, usePage } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { useState } from 'react';

export default function Index({ products, pagination, categories, filters }) {
    const { auth } = usePage().props;
    const [addingToCart, setAddingToCart] = useState(null);
    const [searchTerm, setSearchTerm] = useState(filters?.search || '');
    const [selectedCategory, setSelectedCategory] = useState(filters?.category || '');

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

    const handleSearch = (e) => {
        e.preventDefault();
        router.get(route('products.index'), {
            search: searchTerm,
            category: selectedCategory,
        }, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const handleCategoryChange = (categoryId) => {
        setSelectedCategory(categoryId);
        router.get(route('products.index'), {
            search: searchTerm,
            category: categoryId,
        }, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const handlePageChange = (url) => {
        if (url) {
            router.get(url);
        }
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

                    {/* Search and Filter Section */}
                    <div className="mb-6 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div className="p-6">
                            <form onSubmit={handleSearch} className="flex flex-col gap-4 md:flex-row md:items-end">
                                <div className="flex-1">
                                    <label htmlFor="search" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Search Products
                                    </label>
                                    <input
                                        id="search"
                                        type="text"
                                        value={searchTerm}
                                        onChange={(e) => setSearchTerm(e.target.value)}
                                        placeholder="Search by name..."
                                        className="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                    />
                                </div>
                                <div className="flex-1">
                                    <label htmlFor="category" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Category
                                    </label>
                                    <select
                                        id="category"
                                        value={selectedCategory}
                                        onChange={(e) => handleCategoryChange(e.target.value)}
                                        className="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                    >
                                        <option value="">All Categories</option>
                                        {categories?.map((category) => (
                                            <option key={category.id} value={category.id}>
                                                {category.name}
                                            </option>
                                        ))}
                                    </select>
                                </div>
                                <button
                                    type="submit"
                                    className="rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:bg-white dark:focus:ring-offset-gray-800 dark:active:bg-gray-300"
                                >
                                    Search
                                </button>
                            </form>
                        </div>
                    </div>

                    {/* Products Grid */}
                    <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        {products.map((product) => (
                            <div
                                key={product.id}
                                className="overflow-hidden bg-white shadow-sm transition-shadow hover:shadow-md sm:rounded-lg dark:bg-gray-800"
                            >
                                {product.image_url && (
                                    <img
                                        src={product.image_url}
                                        alt={product.name}
                                        className="h-48 w-full object-cover"
                                    />
                                )}
                                <div className="p-6">
                                    <div className="mb-2 flex items-start justify-between">
                                        <h3 className="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                            {product.name}
                                        </h3>
                                    </div>
                                    
                                    {product.category && (
                                        <span className="inline-block mb-2 rounded-full bg-gray-200 px-3 py-1 text-xs font-semibold text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                            {product.category.name}
                                        </span>
                                    )}
                                    
                                    {product.description && (
                                        <p className="mb-4 text-sm text-gray-600 line-clamp-2 dark:text-gray-400">
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
                                <p className="text-lg">No products found.</p>
                            </div>
                        </div>
                    )}

                    {/* Pagination */}
                    {pagination && pagination.last_page > 1 && (
                        <div className="mt-6 flex items-center justify-between overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                            <div className="p-4">
                                <p className="text-sm text-gray-700 dark:text-gray-300">
                                    Showing page {pagination.current_page} of {pagination.last_page}
                                    {' '}({pagination.total} total products)
                                </p>
                            </div>
                            <div className="flex gap-2 p-4">
                                {pagination.links?.map((link, index) => {
                                    if (link.url === null) {
                                        return (
                                            <span
                                                key={index}
                                                className="px-3 py-1 text-sm text-gray-400 cursor-not-allowed"
                                                dangerouslySetInnerHTML={{ __html: link.label }}
                                            />
                                        );
                                    }
                                    
                                    return (
                                        <button
                                            key={index}
                                            onClick={() => handlePageChange(link.url)}
                                            className={`px-3 py-1 text-sm rounded ${
                                                link.active
                                                    ? 'bg-gray-800 text-white dark:bg-gray-200 dark:text-gray-800'
                                                    : 'bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600'
                                            }`}
                                            dangerouslySetInnerHTML={{ __html: link.label }}
                                        />
                                    );
                                })}
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

