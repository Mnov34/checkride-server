import 'package:flutter/material.dart';

/// Page qui s'affiche automatiquement lors du démarage de l'application,
/// pendant ce temps l'application détermine si l'utilisateur est connecté ou pas <br>
/// L'application renvoie alors vers le bloc Home ou Login (cette logique est dans [app.AppView])
class SplashPage extends StatelessWidget {
  const SplashPage({super.key});

  static Route<void> route() {
    return MaterialPageRoute<void>(builder: (_) => const SplashPage());
  }

  @override
  Widget build(BuildContext context) {
    return const Scaffold(
      body: Center(child: CircularProgressIndicator()),
    );
  }
}
