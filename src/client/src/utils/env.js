export default function getEnv(name) {
    return window?.runtimeConfig?.[name] || process.env[name];
}