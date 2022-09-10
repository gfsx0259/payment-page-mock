const { defineConfig } = require("@vue/cli-service");

module.exports = defineConfig({
  transpileDependencies: true,
  chainWebpack: config => {
    config
      .plugin('eslint')
      .tap(args => {
        args[0].fix = true;

        return args;
      })
  }
});
