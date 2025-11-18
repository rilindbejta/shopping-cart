import { Head, Link } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function Index({ orders }) {
    return (
        <AuthenticatedLayout
            header={
                <div className="flex justify-between items-center">
                    <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                        My Orders
                    </h2>
                    <div className="flex gap-4">
                        <Link
                            href={route('products.index')}
                            className="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 dark:border-gray-500 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800"
                        >
                            Continue Shopping
                        </Link>
                        <Link
                            href={route('cart.index')}
                            className="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:bg-white dark:focus:ring-offset-gray-800 dark:active:bg-gray-300"
                        >
                            View Cart
                        </Link>
                    </div>
                </div>
            }
        >
            <Head title="My Orders" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {orders.length === 0 ? (
                        <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                            <div className="p-6 text-center text-gray-900 dark:text-gray-100">
                                <h3 className="mb-4 text-lg font-semibold">No orders yet</h3>
                                <p className="mb-4 text-gray-600 dark:text-gray-400">
                                    Start shopping to place your first order!
                                </p>
                                <Link
                                    href={route('products.index')}
                                    className="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                >
                                    Browse Products →
                                </Link>
                            </div>
                        </div>
                    ) : (
                        <div className="space-y-6">
                            {orders.map((order) => (
                                <div
                                    key={order.id}
                                    className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                                >
                                    <div className="p-6">
                                        <div className="mb-4 flex items-start justify-between">
                                            <div>
                                                <h3 className="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                    Order #{order.id}
                                                </h3>
                                                <p className="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                    Placed on {order.created_at}
                                                </p>
                                            </div>
                                            <div className="text-right">
                                                <p className="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                                    ${order.total_amount}
                                                </p>
                                                <span
                                                    className={`inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ${
                                                        order.status === 'completed'
                                                            ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                                            : order.status === 'pending'
                                                            ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'
                                                            : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                                    }`}
                                                >
                                                    {order.status.charAt(0).toUpperCase() + order.status.slice(1)}
                                                </span>
                                            </div>
                                        </div>

                                        <div className="border-t border-gray-200 pt-4 dark:border-gray-700">
                                            <h4 className="mb-2 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                Order Items
                                            </h4>
                                            <div className="space-y-2">
                                                {order.items.map((item, index) => (
                                                    <div
                                                        key={index}
                                                        className="flex items-center gap-3 rounded-md bg-gray-50 p-3 dark:bg-gray-700"
                                                    >
                                                        {item.product_image && (
                                                            <img
                                                                src={item.product_image}
                                                                alt={item.product_name}
                                                                className="h-16 w-16 rounded object-cover"
                                                            />
                                                        )}
                                                        <div className="flex flex-1 items-center justify-between">
                                                            <div>
                                                                <p className="font-medium text-gray-900 dark:text-gray-100">
                                                                    {item.product_name}
                                                                </p>
                                                                <p className="text-sm text-gray-600 dark:text-gray-400">
                                                                    ${item.price} × {item.quantity}
                                                                </p>
                                                            </div>
                                                            <div className="text-right">
                                                                <p className="font-semibold text-gray-900 dark:text-gray-100">
                                                                    ${item.subtotal}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                ))}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

