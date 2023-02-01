module.exports = {
    platform: 'github',
    logLevel: 'debug',
    onboardingConfig: {
        extends: ['config:base'],
    },
    repositories: ['Vasary/tac-core'],
    renovateFork: true,
    gitAuthor: "Renovate bot <bot@renovate.io>",
    username: "renovate",
    onboarding: false,
    printConfig: true,
    requireConfig: false,
};
