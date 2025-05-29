package main

import (
	"fmt"
	"os"
	"time"

	"github.com/launchdarkly/go-sdk-common/v3/ldcontext"
	ld "github.com/launchdarkly/go-server-sdk/v7"
)

func showBanner() {
	fmt.Print("\n        ██       \n" +
		"          ██     \n" +
		"      ████████   \n" +
		"         ███████ \n" +
		"██ LAUNCHDARKLY █\n" +
		"         ███████ \n" +
		"      ████████   \n" +
		"          ██     \n" +
		"        ██       \n")
}

func showMessage(s string) { fmt.Printf("*** %s\n\n", s) }

func main() {
	ldClient := setup()

	first_example(ldClient)
	beta_users_example(ldClient)
}

func setup() *ld.LDClient {
	var sdkKey = os.Getenv("LAUNCHDARKLY_SDK_KEY")

	if sdkKey == "" {
		showMessage("LaunchDarkly SDK key is required: set the LAUNCHDARKLY_SDK_KEY environment variable and try again.")
		os.Exit(1)
	}

	ldClient, _ := ld.MakeClient(sdkKey, 5*time.Second)
	if ldClient.Initialized() {
		showMessage("SDK successfully initialized!")
	} else {
		showMessage("SDK failed to initialize")
		os.Exit(1)
	}

	return ldClient
}

func first_example(ldClient *ld.LDClient) {
	const featureFlagKey = "sample-in-private"

	context := ldcontext.NewBuilder(featureFlagKey).Build()

	flagValue, err := ldClient.BoolVariation(featureFlagKey, context, false)
	if err != nil {
		showMessage("error: " + err.Error())
	}

	showMessage(fmt.Sprintf("The '%s' feature flag evaluates to %t.", featureFlagKey, flagValue))

	if flagValue {
		showBanner()
	}
}

func beta_users_example(ldClient *ld.LDClient) {
	const featureFlagKey = "sample-beta-users"
	const userName = "Sandy"

	context := ldcontext.NewBuilder(userName).Name(userName).Build()

	fmt.Println(context)

	flagValue, err := ldClient.BoolVariation(featureFlagKey, context, false)
	if err != nil {
		showMessage("error: " + err.Error())
	}

	if flagValue {
		showMessage("You are a beta user!")
	} else {
		showMessage(fmt.Sprintf("You are not a beta user. %s", userName))
	}
}
