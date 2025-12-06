#!/bin/bash

# Flutter Installation Script for Ubuntu 24.04
# This script installs Flutter SDK 3.24.5 stable

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}=== Flutter Installation Script ===${NC}"
echo ""

# Configuration
FLUTTER_VERSION="3.24.5"
FLUTTER_CHANNEL="stable"
FLUTTER_DIR="$HOME/development"
FLUTTER_PATH="$FLUTTER_DIR/flutter/bin"

# Step 1: Update system
echo -e "${YELLOW}Step 1/9: Updating system packages...${NC}"
sudo apt update

# Step 2: Install dependencies
echo -e "${YELLOW}Step 2/9: Installing dependencies...${NC}"
sudo apt install -y curl git wget unzip libgconf-2-4 gdb libstdc++6 libglu1-mesa fonts-droid-fallback lib32stdc++6 python3 clang cmake ninja-build pkg-config libgtk-3-dev

# Step 3: Create installation directory
echo -e "${YELLOW}Step 3/9: Creating installation directory...${NC}"
mkdir -p "$FLUTTER_DIR"
cd "$FLUTTER_DIR"

# Step 4: Download Flutter SDK
echo -e "${YELLOW}Step 4/9: Downloading Flutter SDK ${FLUTTER_VERSION}...${NC}"
FLUTTER_URL="https://storage.googleapis.com/flutter_infra_release/releases/${FLUTTER_CHANNEL}/linux/flutter_linux_${FLUTTER_VERSION}-${FLUTTER_CHANNEL}.tar.xz"
wget -O flutter_sdk.tar.xz "$FLUTTER_URL"

# Step 5: Extract Flutter SDK
echo -e "${YELLOW}Step 5/9: Extracting Flutter SDK...${NC}"
tar xf flutter_sdk.tar.xz
rm flutter_sdk.tar.xz

# Step 6: Add Flutter to PATH
echo -e "${YELLOW}Step 6/9: Configuring PATH...${NC}"
if ! grep -q "flutter/bin" ~/.bashrc; then
    echo "" >> ~/.bashrc
    echo "# Flutter PATH" >> ~/.bashrc
    echo "export PATH=\"\$PATH:$FLUTTER_PATH\"" >> ~/.bashrc
    echo -e "${GREEN}Flutter PATH added to ~/.bashrc${NC}"
fi

# Also add to current session
export PATH="$PATH:$FLUTTER_PATH"

# Step 7: Pre-download development binaries
echo -e "${YELLOW}Step 7/9: Pre-downloading Flutter development binaries...${NC}"
$FLUTTER_PATH/flutter precache

# Step 8: Run Flutter doctor
echo -e "${YELLOW}Step 8/9: Running Flutter doctor...${NC}"
$FLUTTER_PATH/flutter doctor

# Step 9: Android Studio (optional)
echo ""
echo -e "${YELLOW}Step 9/9: Android Studio installation${NC}"
read -p "Do you want to install Android Studio? (y/n): " install_android_studio

if [[ $install_android_studio =~ ^[Yy]$ ]]; then
    echo -e "${YELLOW}Downloading Android Studio...${NC}"
    cd ~/Downloads
    wget https://redirector.gvt1.com/edgedl/android/studio/ide-zips/2024.1.1.12/android-studio-2024.1.1.12-linux.tar.gz
    
    echo -e "${YELLOW}Extracting Android Studio...${NC}"
    sudo tar -xzf android-studio-*-linux.tar.gz -C /opt/
    
    echo -e "${YELLOW}Creating desktop entry...${NC}"
    cat > ~/.local/share/applications/android-studio.desktop <<EOF
[Desktop Entry]
Version=1.0
Type=Application
Name=Android Studio
Icon=/opt/android-studio/bin/studio.png
Exec=/opt/android-studio/bin/studio.sh
Categories=Development;IDE;
Terminal=false
EOF
    
    echo -e "${GREEN}Android Studio installed to /opt/android-studio${NC}"
    echo -e "${GREEN}Launch it from: /opt/android-studio/bin/studio.sh${NC}"
fi

echo ""
echo -e "${GREEN}=== Installation Complete! ===${NC}"
echo ""
echo -e "${YELLOW}Next Steps:${NC}"
echo "1. Restart your terminal or run: source ~/.bashrc"
echo "2. Verify installation: flutter doctor -v"
echo "3. Accept Android licenses: flutter doctor --android-licenses"
echo "4. Install VS Code extensions (optional):"
echo "   - Flutter"
echo "   - Dart"
echo ""
echo -e "${GREEN}Flutter ${FLUTTER_VERSION} is now installed!${NC}"
