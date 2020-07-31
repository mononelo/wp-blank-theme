const path = require('path')
const webpack = require('webpack')
const minJSON = require('jsonminify')

const plugins = {
    Progress: require('webpackbar'),
    Clean: require('clean-webpack-plugin'),
    ExtractCSS: require('mini-css-extract-plugin'),
    Html: require('html-webpack-plugin'),
    Copy: require('copy-webpack-plugin'),
    Sri: require('webpack-subresource-integrity'),
    Assets: require('assets-webpack-plugin'),
    ManifestPlugin: require('webpack-manifest-plugin')
}

const dist = 'assets'

module.exports = (env = {}, argv) => {
    const isProduction = argv.mode === 'production'

    let config = {
        context: path.resolve(__dirname, 'resources'),
        entry: {
            app: [
                './scss/app.scss',
                './js/app.js'
            ]
        },
        output: {
            path: path.resolve(__dirname, dist),
            publicPath: '/assets/',
            filename: isProduction ? '[name].[hash].js' : '[name].js',
            crossOriginLoading: 'anonymous'
        },
        module: {
            rules:
        [{
            test: /\.((s[ac]|c)ss)$/,
            use: [
                plugins.ExtractCSS.loader,
                {
                    loader: 'css-loader',
                    options: {
                        sourceMap: !isProduction
                    }
                },
                {
                    loader: 'postcss-loader',
                    options: {
                        ident: 'postcss',
                        sourceMap: !isProduction,
                        plugins: () => [
                            require('autoprefixer')({grid: 'autoplace'}),
                            ...isProduction ? [
                                require('cssnano')({
                                    preset: ['default', {
                                        minifySelectors: false
                                    }]
                                })
                            ] : []
                        ]
                    }
                },
                {
                    loader: 'sass-loader',
                    options: {
                        outputStyle: 'compressed',
                        sourceMap: !isProduction
                    }
                }
            ]
        },
        {
            test: /\.js$/,
            exclude: /node_modules/,
            use: {
                loader: 'babel-loader'
            }
        },/*
        {
            test: /\.js$/,
            exclude: /node_modules/,
            use: {
                loader: 'eslint-loader'
            }
        },*/
        {
            test: /\.(gif|png|jpe?g|svg)$/i,
            exclude: path.resolve(__dirname, 'resources/fonts'),
            use: [
                {
                    loader: 'file-loader',
                    options: {
                        name: isProduction ? '[path][name].[hash].[ext]' : '[path][name].[ext]',
                        //outputPath: 'img',
                        useRelativePaths: true,
                        publicPath: '../' // use relative urls
                    }
                },
                {
                    loader: 'image-webpack-loader',
                    options: {
                        bypassOnDebug: !isProduction,
                        mozjpeg: {
                            progressive: true,
                            quality: 65
                        },
                        optipng: {
                            enabled: false
                        },
                        pngquant: {
                            quality: '65-90',
                            speed: 4
                        },
                        gifsicle: {
                            interlaced: false
                        }
                    }
                }
            ]
        },
        {
            test: /.(ttf|otf|eot|svg|woff(2)?)(\?[a-z0-9]+)?$/,
            exclude: /img/,
            use: [{
                loader: 'file-loader',
                options: {
                    name: isProduction ? '[name].[hash].[ext]' : '[name].[ext]',
                    outputPath: 'fonts/',
                    publicPath: '../fonts/' // use relative urls
                }
            }]
        },
        {
            test: /\.(mp4)$/i,
            exclude: /img/,
            use: [{
                loader: 'file-loader',
                options: {
                    name: isProduction ? '[name].[hash].[ext]' : '[name].[ext]',
                    outputPath: 'video/',
                    publicPath: '../video/' // use relative urls
                }
            }]
        },
        {
            test: /\.html$/,
            use: {
                loader: 'html-loader',
                options: {
                    minimize: true,
                    removeComments: true,
                    collapseWhitespace: true,
                    removeScriptTypeAttributes: true,
                    removeStyleTypeAttributes: true
                }
            }
        }]
        },
        devServer: {
            contentBase: [path.join(__dirname, 'resources'), path.join(__dirname, 'src')],
            port: 8080,
			allowedHosts: [
                'mononelo'
			],
            overlay: {
                warnings: true,
                errors: true
            },
            watchContentBase: false,
            quiet: true,
            hot: false,
            liveReload: true,
            headers: {
                'Access-Control-Allow-Origin': '*'
            }
        },
        plugins: (() => {
            let common = [
                new plugins.ExtractCSS({
                    filename: isProduction ? 'css/[name].[hash].css' : 'css/[name].css'
                }),
                new plugins.Progress({
                    color: '#A37989'
                }),
                new webpack.ProvidePlugin({
                    $: 'jquery',
                    jQuery: 'jquery',
                    jquery: 'jquery',
                    'window.jQuery': 'jquery'
                }),
                new plugins.Assets({
                    path: path.join(__dirname, dist),
                    filename: 'assets.json',

                })
            ]
            const production = [
                new plugins.Clean([dist]),
                new plugins.Copy([
                    {
                        from: 'data/**/*.json',
                        // to: '',
                        transform: content => {
                            return minJSON(content.toString())
                        }
                    }
                ]),
                new plugins.Sri({
                    hashFuncNames: ['sha384'],
                    enabled: true
                }),
                new plugins.ManifestPlugin()
            ]

            const development = [
            ]

            return isProduction
                ? common.concat(production)
                : common.concat(development)
        })(),

        devtool: (() => {
            return isProduction
                ? '' // 'hidden-source-map'
                : 'source-map'
        })(),

        resolve: {
            modules: [path.resolve(__dirname, 'src'), 'node_modules'],
            alias: {
                '~': path.resolve(__dirname, 'resources/js/')
            }
        },

        stats: 'errors-only'
    }

    return config
}