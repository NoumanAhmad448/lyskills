const path = require('path');
const webpack = require('webpack');

module.exports = {
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
        },
        extensions: ['.*', '.wasm', '.mjs', '.js', '.jsx', '.json'],
        fallback: {
            buffer: require.resolve('buffer/'),
        },
    },
    plugins: [
        new webpack.ProvidePlugin({
            Buffer: ['buffer', 'Buffer'],
        }),
    ],
};